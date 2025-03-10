<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class AuditorDashboardController extends Controller
{
    public function index()
    {
        return view('auditor.dashboard');
    }

    public function conversions()
    {
        $sales = Sale::query()
            ->where('auditor_id', auth()->id())
            ->get();

        return view('auditor.conversions')->with([
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

        return redirect()->route('auditor.conversions')
            ->with('success', 'Conversão atualizada com sucesso.');
    }
}
