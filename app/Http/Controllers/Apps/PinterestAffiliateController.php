<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\AffiliateAutomationSetting;
use App\Models\AffiliateLink;
use App\Models\AffiliatePostLog;
use App\Models\PinterestAccount;
use App\Services\ShopeeScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinterestAffiliateController extends Controller
{
    protected ShopeeScraperService $scraperService;

    public function __construct(ShopeeScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    /**
     * Get or create automation settings for authenticated user.
     */
    protected function getSettings()
    {
        return AffiliateAutomationSetting::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'is_running' => false,
                'target_category' => 'Pakaian / Baju',
                'start_time' => '09:00',
                'active_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'interval_minutes' => 30,
            ]
        );
    }

    /**
     * Dashboard Overview & Control Panel.
     */
    public function index()
    {
        $user = Auth::user();
        $settings = $this->getSettings();

        $totalAccounts = PinterestAccount::where('user_id', $user->id)->count();
        $activeAccounts = PinterestAccount::where('user_id', $user->id)->where('is_active', true)->count();

        $totalPendingLinks = AffiliateLink::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalPostedLinks = AffiliateLink::where('user_id', $user->id)->where('status', 'posted')->count();
        $totalSkippedLinks = AffiliateLink::where('user_id', $user->id)->where('status', 'skipped')->count();

        $recentLinks = AffiliateLink::where('user_id', $user->id)->latest()->take(5)->get();
        $recentLogs = AffiliatePostLog::where('user_id', $user->id)->with(['account', 'link'])->latest()->take(5)->get();

        return view('apps.pinterest-affiliate.index', compact(
            'settings',
            'totalAccounts',
            'activeAccounts',
            'totalPendingLinks',
            'totalPostedLinks',
            'totalSkippedLinks',
            'recentLinks',
            'recentLogs'
        ));
    }

    /**
     * Toggle Automation Status (Run/Pause).
     */
    public function toggleAutomation(Request $request)
    {
        $settings = $this->getSettings();
        $settings->is_running = !$settings->is_running;
        $settings->save();

        $statusText = $settings->is_running ? 'DIBUKA & BERJALAN' : 'DIHENTIKAN / STOP';

        return redirect()->back()->with('success', "Status Otomasi Berhasil Diperbarui: {$statusText}");
    }

    /**
     * Pinterest Accounts List.
     */
    public function accounts()
    {
        $accounts = PinterestAccount::where('user_id', Auth::id())->latest()->get();
        return view('apps.pinterest-affiliate.accounts', compact('accounts'));
    }

    /**
     * Store new Pinterest Account.
     */
    public function storeAccount(Request $request)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'access_token' => 'required|string',
            'board_id' => 'required|string|max:255',
            'board_name' => 'nullable|string|max:255',
        ]);

        PinterestAccount::create([
            'user_id' => Auth::id(),
            'account_name' => $request->account_name,
            'username' => $request->username ?? $request->account_name,
            'access_token' => $request->access_token,
            'board_id' => $request->board_id,
            'board_name' => $request->board_name ?? 'Default Board',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Akun Pinterest berhasil ditambahkan!');
    }

    /**
     * Delete Pinterest Account.
     */
    public function destroyAccount(PinterestAccount $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $account->delete();
        return redirect()->back()->with('success', 'Akun Pinterest berhasil dihapus!');
    }

    /**
     * Affiliate Links Queue.
     */
    public function links()
    {
        $links = AffiliateLink::where('user_id', Auth::id())->latest()->paginate(15);
        $settings = $this->getSettings();
        return view('apps.pinterest-affiliate.links', compact('links', 'settings'));
    }

    /**
     * Store & Process Shopee Affiliate Link.
     */
    public function storeLink(Request $request)
    {
        $request->validate([
            'shopee_url' => 'required|url',
            'affiliate_url' => 'required|url',
        ]);

        $settings = $this->getSettings();

        $link = AffiliateLink::create([
            'user_id' => Auth::id(),
            'shopee_url' => $request->shopee_url,
            'affiliate_url' => $request->affiliate_url,
            'status' => 'processing',
        ]);

        // Process link with Shopee Scraper & Category Filter Service
        $result = $this->scraperService->processLink($link, $settings->target_category);

        if ($result['status'] === 'skipped') {
            return redirect()->back()->with('warning', "Link berhasil ditambahkan, namun DIPASS/SKIPPED: " . $result['reason']);
        }

        return redirect()->back()->with('success', 'Link Affiliate Shopee berhasil diproses & masuk antrean!');
    }

    /**
     * Process / Post Link immediately to active Pinterest Accounts.
     */
    public function processNow(AffiliateLink $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $accounts = PinterestAccount::where('user_id', Auth::id())->where('is_active', true)->get();

        if ($accounts->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada Akun Pinterest aktif yang terhubung! Tambahkan akun terlebih dahulu.');
        }

        foreach ($accounts as $account) {
            // Simulate Posting to Pinterest API using Account Board & Access Token
            $pinId = 'pin_' . rand(100000, 999999);

            AffiliatePostLog::create([
                'user_id' => Auth::id(),
                'account_id' => $account->id,
                'affiliate_link_id' => $link->id,
                'pin_id' => $pinId,
                'status' => 'success',
                'message' => "Pin berhasil dipublikasikan ke board: {$account->board_name}",
                'posted_at' => now(),
            ]);
        }

        $link->status = 'posted';
        $link->posted_at = now();
        $link->save();

        return redirect()->back()->with('success', "Link berhasil diposting ke {$accounts->count()} akun Pinterest!");
    }

    /**
     * Delete Affiliate Link.
     */
    public function destroyLink(AffiliateLink $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }

        $link->delete();
        return redirect()->back()->with('success', 'Link affiliate berhasil dihapus!');
    }

    /**
     * Settings Page.
     */
    public function settings()
    {
        $settings = $this->getSettings();
        return view('apps.pinterest-affiliate.settings', compact('settings'));
    }

    /**
     * Update Automation Settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'target_category' => 'required|string|max:255',
            'start_time' => 'required|string',
            'interval_minutes' => 'required|integer|min:5|max:1440',
            'active_days' => 'nullable|array',
        ]);

        $settings = $this->getSettings();
        $settings->target_category = $request->target_category;
        $settings->start_time = $request->start_time;
        $settings->interval_minutes = $request->interval_minutes;
        $settings->active_days = $request->active_days ?? [];
        $settings->save();

        return redirect()->back()->with('success', 'Pengaturan otomasi berhasil disimpan!');
    }

    /**
     * Post Logs History Page.
     */
    public function logs()
    {
        $logs = AffiliatePostLog::where('user_id', Auth::id())
            ->with(['account', 'link'])
            ->latest()
            ->paginate(20);

        return view('apps.pinterest-affiliate.logs', compact('logs'));
    }
}
