<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;

class AuditorDashboardController extends Controller
{
    public function index()
    {
        return view('auditor.dashboard');
    }
}
