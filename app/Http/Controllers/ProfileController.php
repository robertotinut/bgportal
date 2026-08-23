<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AppModule;

class ProfileController extends Controller
{
    /**
     * Show profile & account settings page.
     */
    public function index()
    {
        $user = Auth::user();
        $assignedApps = $user->accessibleApps();

        return view('profile.index', compact('user', 'assignedApps'));
    }

    /**
     * Update user profile information or password.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // If changing password, verify current password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Password lama yang Anda masukkan salah.');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil akun Anda berhasil diperbarui!');
    }

    /**
     * Show account status & subscription details page.
     */
    public function subscription()
    {
        $user = Auth::user();
        $assignedApps = $user->accessibleApps();

        return view('profile.subscription', compact('user', 'assignedApps'));
    }
}
