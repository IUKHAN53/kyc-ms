<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ManagesUsers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    use ManagesUsers;

    /**
     * Display a listing of auditors.
     */
    public function index()
    {
        $auditors = User::where('role', 'auditor')->paginate(10);

        return view('admin.auditors.index', compact('auditors'));
    }

    /**
     * Store a newly created auditor.
     */
    public function store(Request $request)
    {
        // No extra rules are required.
        return $this->storeUser($request, 'auditor', 'auditors');
    }

    /**
     * Update the specified auditor.
     */
    public function update(Request $request, User $auditor)
    {
        return $this->updateUser($request, $auditor, 'auditor', 'auditors');
    }

    /**
     * Remove the specified auditor.
     */
    public function destroy(User $auditor)
    {
        return $this->destroyUser($auditor, 'auditor');
    }
}
