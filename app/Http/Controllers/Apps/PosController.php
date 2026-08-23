<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosController extends Controller
{
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
