<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConversionController extends Controller
{
    /**
     * Display a listing of conversions.
     */
    public function index()
    {
        $sales = Sale::with(['client', 'group', 'user', 'auditor'])->paginate(10);
        $clients = \App\Models\Client::all();
        $groups = \App\Models\Group::all();
        return view('admin.sales.index', compact('sales', 'clients', 'groups'));
    }

    /**
     * Store a new conversion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'group_id'      => 'required|exists:groups,id',
            'jira_status'    => 'required|string',
            'jira_id'        => 'required|string',
            'backoffice_id'  => 'required|string',
            'date'           => 'required|date',
            'hour'           => 'required|string',
            'bonus'          => 'required|string',
            'voucher_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'         => 'required|in:pending,approved,rejected',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('voucher_image')) {
            $path = $request->file('voucher_image')->store('conversions', 'public');
            $validated['voucher_image'] = $path;
        }

        $validated['user_id'] = auth()->id();

        Sale::create($validated);

        return redirect()->route('admin.sales.index')->with('success', 'Conversão cadastrada com sucesso.');
    }

    /**
     * Update a conversion.
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'group_id'      => 'required|exists:groups,id',
            'jira_status'    => 'required|string',
            'jira_id'        => 'required|string',
            'backoffice_id'  => 'required|string',
            'date'           => 'required|date',
            'hour'           => 'required|string',
            'bonus'          => 'required|string',
            'voucher_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'         => 'required|in:pending,approved,rejected',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('voucher_image')) {
            if ($sale->voucher_image && Storage::disk('public')->exists($sale->voucher_image)) {
                Storage::disk('public')->delete($sale->voucher_image);
            }
            $path = $request->file('voucher_image')->store('conversions', 'public');
            $validated['voucher_image'] = $path;
        } else {
            unset($validated['voucher_image']);
        }

        $sale->update($validated);

        return redirect()->route('admin.sales.index')->with('success', 'Conversão atualizada com sucesso.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->voucher_image && Storage::disk('public')->exists($sale->voucher_image)) {
            Storage::disk('public')->delete($sale->voucher_image);
        }

        $sale->delete();

        return redirect()->route('admin.sales.index')->with('success', 'Conversão removida com sucesso.');
    }
}
