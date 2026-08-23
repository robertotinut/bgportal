<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@bgportal.com'],
            [
                'name' => 'Admin BGPortal',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Create Regular User
        $staff = User::updateOrCreate(
            ['email' => 'staff@bgportal.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        // Create Sample Central Applications
        $hris = App::updateOrCreate(
            ['code' => 'hris'],
            [
                'name' => 'HRIS System',
                'url' => 'https://hris.bgportal.test',
                'icon' => 'bi bi-people',
                'description' => 'Sistem Manajemen Sumber Daya Manusia & Penggajian',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $finance = App::updateOrCreate(
            ['code' => 'finance'],
            [
                'name' => 'Finanza Keuangan & Anggaran',
                'url' => '/apps/finance',
                'icon' => 'bi bi-wallet2',
                'description' => 'Pencatatan Keuangan, Target Anggaran & Tabungan Personal/Shared',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $inventory = App::updateOrCreate(
            ['code' => 'inventory'],
            [
                'name' => 'Inventory & Warehouse',
                'url' => 'https://inventory.bgportal.test',
                'icon' => 'bi bi-box-seam',
                'description' => 'Manajemen Stok Barang & Gudang Central',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        $pos = App::updateOrCreate(
            ['code' => 'pos'],
            [
                'name' => 'POS Prime',
                'url' => '/apps/pos',
                'icon' => 'bi bi-shop',
                'description' => 'Aplikasi Kasir & Penjualan Outlet',
                'is_active' => true,
                'sort_order' => 4,
            ]
        );

        $pinterest = App::updateOrCreate(
            ['code' => 'pinterest_affiliate'],
            [
                'name' => 'Pinterest Affiliate AutoPost',
                'url' => '/apps/pinterest-affiliate',
                'icon' => 'bi bi-pinterest',
                'description' => 'Otomasi Scraping & Auto Post Affiliate Shopee ke Pinterest Multi-Account',
                'is_active' => true,
                'sort_order' => 5,
            ]
        );

        // Assign access to regular staff user (HRIS, Finance, Inventory, POS & Pinterest)
        $staff->apps()->sync([$hris->id, $finance->id, $inventory->id, $pos->id, $pinterest->id]);
    }
}
