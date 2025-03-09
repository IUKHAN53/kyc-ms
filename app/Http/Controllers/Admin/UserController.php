<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ManagesUsers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ManagesUsers;

    public function index()
    {
        $users = User::where('role', 'user')->paginate(10);
        $groups = \App\Models\Group::all();
        $clients = \App\Models\Client::all();

        return view('admin.agents.index', compact('users', 'groups', 'clients'));
    }

    public function store(Request $request)
    {
        return $this->storeUser(
            $request,
            'user',
            'agents',
            [
                'group_id' => 'required|exists:groups,id',
                'client_id' => 'required|exists:clients,id',
            ]
        );
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        return $this->updateUser(
            $request,
            $user,
            'user',
            'agents',
            [
                'group_id' => 'required|exists:groups,id',
                'client_id' => 'required|exists:clients,id',
            ]
        );
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);

        return $this->destroyUser($user, 'user');
    }
}
