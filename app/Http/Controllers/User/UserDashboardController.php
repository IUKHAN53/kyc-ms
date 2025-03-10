<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function conversions()
    {
        $sales = Sale::query()
            ->where('user_id', auth()->id())
            ->get();

        return view('user.conversions')->with([
            'sales' => $sales,
        ]);
    }

    public function storeSale(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'group_id' => 'required|exists:groups,id',
            'jira_status' => 'required|string',
            'jira_id' => 'required|string',
            'backoffice_id' => 'required|string',
            'date' => 'required|date',
            'hour' => 'required|string',
            'bonus' => 'required|string',
            'voucher_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:pending,approved,rejected',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('voucher_image')) {
            $path = $request->file('voucher_image')->store('conversions', 'public');
            $validated['voucher_image'] = $path;
        }

        $validated['user_id'] = auth()->id();

        Sale::create($validated);

        return redirect()->route('user.conversions')->with('success', 'Conversão cadastrada com sucesso.');
    }
}
