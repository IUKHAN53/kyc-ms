<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        return view('supervisor.dashboard');
    }

    public function conversions()
    {
        $sales = Sale::query()
            ->where('auditor_id', auth()->id())
            ->get();

        return view('supervisor.conversions')->with([
            'sales' => $sales,
        ]);
    }

    public function changeStatus(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'description' => 'nullable|string',
        ]);
        $sale->update($validated);

        return redirect()->route('supervisor.conversions')
            ->with('success', 'Conversão atualizada com sucesso.');
    }

    public function reports()
    {
        return view('supervisor.reports');
    }
}
