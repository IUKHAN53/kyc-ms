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
if (! function_exists('getMenu')) {
    function getMenu(): array
    {
        $navItems = [];
        if (isAdmin()) {
            $navItems = [
                [
                    'route' => 'admin.dashboard',
                    'icon' => asset('assets/img/home.png'),
                    'title' => 'Dashboard',
                    'isImage' => true,
                ],
                [
                    'route' => 'admin.reports.index',
                    'icon' => 'bi bi-graph-up-arrow',
                    'title' => 'Relatorios',
                    'isImage' => false,
                ],
                [
                    'route' => 'admin.sales.index',
                    'icon' => 'bi bi-receipt-cutoff',
                    'title' => 'Conversions',
                    'isImage' => false,
                ],
            ];
        } elseif (isAuditor()) {
            $navItems = [
                [
                    'route' => 'auditor.dashboard',
                    'icon' => asset('assets/img/home.png'),
                    'title' => 'Dashboard',
                    'isImage' => true,
                ],
                [
                    'route' => 'auditor.conversions',
                    'icon' => 'bi bi-alarm',
                    'title' => 'Minhas Auditorias',
                    'isImage' => false,
                ],
            ];
        } elseif (isSupervisor()) {
            $navItems = [
                [
                    'route' => 'supervisor.dashboard',
                    'icon' => asset('assets/img/home.png'),
                    'title' => 'Dashboard',
                    'isImage' => true,
                ],
                [
                    'route' => 'supervisor.conversions',
                    'icon' => 'bi bi-alarm',
                    'title' => 'Conversoes',
                    'isImage' => false,
                ],
                [
                    'route' => 'supervisor.reports',
                    'icon' => 'bi bi-graph-up-arrow',
                    'title' => 'Relatorios',
                    'isImage' => false,
                ],
            ];
        } elseif (isUser()) {
            $navItems = [
                [
                    'route' => 'user.dashboard',
                    'icon' => asset('assets/img/home.png'),
                    'title' => 'Dashboard',
                    'isImage' => true,
                ],
                [
                    'route' => 'user.conversions',
                    'icon' => 'bi bi-alarm',
                    'title' => 'Minhas Conversões',
                    'isImage' => false,
                ],
            ];
        } else {
            $navItems = [
                [
                    'route' => 'dashboard',
                    'icon' => asset('assets/img/home.png'),
                    'title' => 'Dashboard',
                    'isImage' => true,
                ],
            ];
        }

        return $navItems;
    }
}
