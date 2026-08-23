<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppManagementController extends Controller
{
    /**
     * Display a listing of applications.
     */
    public function index(Request $request)
    {
        $query = App::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $apps = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.apps.index', compact('apps'));
    }

    /**
     * Show the form for creating a new application.
     */
    public function create()
    {
        return view('admin.apps.create');
    }

    /**
     * Store a newly created application in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:apps,code'],
            'url' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        App::create($validated);

        return redirect()->route('admin.apps.index')
            ->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified application.
     */
    public function edit(App $app)
    {
        return view('admin.apps.edit', compact('app'));
    }

    /**
     * Update the specified application in storage.
     */
    public function update(Request $request, App $app)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', Rule::unique('apps', 'code')->ignore($app->id)],
            'url' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $app->update($validated);

        return redirect()->route('admin.apps.index')
            ->with('success', 'Aplikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified application from storage.
     */
    public function destroy(App $app)
    {
        $app->delete();

        return redirect()->route('admin.apps.index')
            ->with('success', 'Aplikasi berhasil dihapus.');
    }
}
