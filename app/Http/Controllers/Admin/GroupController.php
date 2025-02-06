<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return view('admin.groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'daily_goal' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'monthly_goal' => 'required|numeric',
        ]);

        Group::create($validatedData);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo criado com sucesso.');
    }

    public function update(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'daily_goal' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'monthly_goal' => 'required|numeric',
        ]);

        $group->update($validatedData);
        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo atualizado com sucesso.');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo removido com sucesso.');
    }
}
