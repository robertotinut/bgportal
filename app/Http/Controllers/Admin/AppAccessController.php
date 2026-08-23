<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\User;
use Illuminate\Http\Request;

class AppAccessController extends Controller
{
    /**
     * Display listing of users and their app permissions.
     */
    public function index(Request $request)
    {
        $query = User::with('apps');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name', 'asc')->paginate(10);
        $allApps = App::where('is_active', true)->get();

        return view('admin.app-access.index', compact('users', 'allApps'));
    }

    /**
     * Show form to edit user app permissions.
     */
    public function edit(User $user)
    {
        $apps = App::orderBy('sort_order', 'asc')->get();
        $userAppIds = $user->apps->pluck('id')->toArray();

        return view('admin.app-access.edit', compact('user', 'apps', 'userAppIds'));
    }

    /**
     * Update user app permissions.
     */
    public function update(Request $request, User $user)
    {
        $appIds = $request->input('apps', []);
        
        $user->apps()->sync($appIds);

        return redirect()->route('admin.app-access.index')
            ->with('success', "Hak akses aplikasi untuk user {$user->name} berhasil diperbarui.");
    }
}
