<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Map tên role (string trong route) → số tinyint trong DB
        // Vì routes vẫn dùng 'role:patient', 'role:doctor', 'role:admin'
        // nhưng DB lưu role = 0, 1, 2
        $roleMap = [
            'patient' => 0,
            'doctor'  => 1,
            'admin'   => 2,
        ];

        $requiredRole = $roleMap[$role] ?? null;

        if (!auth()->check() || auth()->user()->role !== $requiredRole) {
            abort(403, 'Unavailable!');
        }

        return $next($request);
    }
}
