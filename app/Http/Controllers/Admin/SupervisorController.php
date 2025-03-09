<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ManagesUsers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    use ManagesUsers;

    /**
     * Display a listing of supervisors.
     */
    public function index()
    {
        $supervisors = User::where('role', 'supervisor')->paginate(10);
        $groups = \App\Models\Group::all();

        return view('admin.supervisors.index', compact('supervisors', 'groups'));
    }

    /**
     * Store a newly created supervisor.
     */
    public function store(Request $request)
    {
        // Supervisors require a group.
        return $this->storeUser(
            $request,
            'supervisor',
            'supervisors',
            ['group_id' => 'required|exists:groups,id']
        );
    }

    /**
     * Update the specified supervisor.
     */
    public function update(Request $request, User $supervisor)
    {
        return $this->updateUser(
            $request,
            $supervisor,
            'supervisor',
            'supervisors',
            ['group_id' => 'required|exists:groups,id']
        );
    }

    /**
     * Remove the specified supervisor.
     */
    public function destroy(User $supervisor)
    {
        return $this->destroyUser($supervisor, 'supervisor');
    }
}
