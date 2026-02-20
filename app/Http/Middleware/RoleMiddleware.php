<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!session()->has('user')) {
            return redirect('/login');
        }

        $roleId = session('user.role_id');

        // Mapping role name -> role_id
        $map = [
            'Admin'  => 1,
            'Doctor' => 2,
            'Nurse'  => 3,
        ];

        $allowedRoleIds = [];
        foreach ($roles as $roleName) {
            if (isset($map[$roleName])) {
                $allowedRoleIds[] = $map[$roleName];
            }
        }

        if (!in_array($roleId, $allowedRoleIds)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
