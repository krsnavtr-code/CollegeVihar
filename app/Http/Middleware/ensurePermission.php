<?php

namespace App\Http\Middleware;

use App\Models\AdminPage;
use Closure;
use Illuminate\Http\Request;

class ensurePermission
{
//     public function handle(Request $request, Closure $next)
//     {
        
//         $permissions = $request->admin_permissions;
//         $page_id = AdminPage::where("admin_page_url", $request->slug)->first()->toArray()['id'];

//         if (in_array($page_id, $permissions) || $permissions[0] == '*') {
//             return $next($request);
//         }

//         if (!auth()->user() || !auth()->user()->hasPermission('send_email')) {
//             abort(403, 'Unauthorized action.');
//         }
        
//         return redirect()->route('admin_home');
//     }

    public function handle(Request $request, Closure $next)
    {
        // Ensure admin_permissions exists in the request
        $permissions = $request->admin_permissions ?? [];

        // Fetch page details
        $page = AdminPage::where("admin_page_url", $request->slug)->first();

        // If the page is not found, abort with a 404 error
        if (!$page) {
            abort(404, 'Page not found.');
        }

        $page_id = $page->id;

        // Check if the user has permission
        if (in_array($page_id, $permissions) || (isset($permissions[0]) && $permissions[0] == '*')) {
            return $next($request);
        }

        // Check if the user has send_email permission
        if (!auth()->user() || !auth()->user()->hasPermission('send_email')) {
            abort(403, 'Unauthorized action.');
        }

        return redirect()->route('admin_home');
    }
}


    