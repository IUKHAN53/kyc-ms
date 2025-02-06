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

if (! function_exists('isRole')) {
    function isRole($role): bool
    {
        return auth()->check() && auth()->user()->role === $role;
    }
}

if (! function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return isRole('admin');
    }
}

if (! function_exists('isSupervisor')) {
    function isSupervisor(): bool
    {
        return isRole('supervisor');
    }
}

if (! function_exists('isAuditor')) {
    function isAuditor(): bool
    {
        return isRole('auditor');
    }
}

if (! function_exists('isUser')) {
    function isUser(): bool
    {
        return isRole('user');
    }
}

if (! function_exists('isActiveRoute')) {
    function isActiveRoute($route): string
    {
        return request()->routeIs($route) ? 'active' : '';
    }
}

