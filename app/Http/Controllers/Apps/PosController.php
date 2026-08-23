<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosController extends Controller
{
    /**
     * Authorize access to POS module.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->canAccessApp('pos')) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses ke modul aplikasi POS.');
            }
            return $next($request);
        });
    }

    /**
     * Display the main POS Cashier interface.
     */
    public function index()
    {
        return view('apps.pos.index');
    }

    /**
     * Display POS Sales Reports.
     */
    public function reports()
    {
        return view('apps.pos.reports');
    }

    /**
     * Display POS Product Management.
     */
    public function products()
    {
        return view('apps.pos.products');
    }
}
