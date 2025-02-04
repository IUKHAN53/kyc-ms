<?php

if (! function_exists('redirectToDashboard')) {
    function redirectToDashboard($user): string
    {
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'supervisor') {
            return route('supervisor.dashboard');
        } elseif ($user->role === 'auditor') {
            return route('auditor.dashboard');
        }

        return route('user.dashboard');
    }
}
