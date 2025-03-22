<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has("admin_username")) {
            $employee = Employee::where('emp_username', session()->get('admin_username'))->with('jobrole')->first();
            if (!$employee) {
                return redirect()->route('admin_logout');
            }
            $path = $request->path();
            $slug = substr($path, strpos($path, "/") + 1);
            if (is_numeric(substr($path, -1, 1))) {
                $slug = substr($slug, 0, strrpos($slug, "/"));
            }
            $permissions = json_decode($employee['jobrole']['permissions'], true);
            $request->merge(['admin_permissions' => $permissions, "slug"=>$slug,'admin_data'=>$employee]);
            return $next($request);
        } else {
            return redirect()->route("admin_login");
        }
    }
}
