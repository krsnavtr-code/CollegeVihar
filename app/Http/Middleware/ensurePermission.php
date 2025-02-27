<?php

namespace App\Http\Middleware;

use App\Models\AdminPage;
use Closure;
use Illuminate\Http\Request;

class ensurePermission
{
    public function handle(Request $request, Closure $next)
    {
        
        $permissions = $request->admin_permissions;
        $page_id = AdminPage::where("admin_page_url", $request->slug)->first()->toArray()['id'];

        if (in_array($page_id, $permissions) || $permissions[0] == '*') {
            return $next($request);
        }
        return redirect()->route('admin_home');
    }
}
