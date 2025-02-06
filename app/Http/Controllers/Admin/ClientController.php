<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        // You can use paginate() if you expect many clients.
        $clients = Client::paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Store image in the 'clients' folder in the public disk.
            $path = $request->file('image')->store('clients', 'public');
            $validatedData['image'] = $path;
        }

        Client::create($validatedData);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client created successfully.');
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($client->image && Storage::disk('public')->exists($client->image)) {
                Storage::disk('public')->delete($client->image);
            }
            $path = $request->file('image')->store('clients', 'public');
            $validatedData['image'] = $path;
        } else {
            // Keep the current image if no new image is uploaded.
            unset($validatedData['image']);
        }

        $client->update($validatedData);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage (optional).
     */
    public function destroy(Client $client)
    {
        if ($client->image && Storage::disk('public')->exists($client->image)) {
            Storage::disk('public')->delete($client->image);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client deleted successfully.');
    }
}
