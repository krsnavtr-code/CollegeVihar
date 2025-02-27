<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
       
         // Define the current route
        //  $route = $request->route();
        //  $sessionExpiresAt = Session::get('user_active_until');

        //    // Check if the user is not active or session has expired
        //    if (!$sessionExpiresAt || Carbon::now()->greaterThan($sessionExpiresAt)) {
        //     // Clear the session if expired
        //     Session::forget('user_active');
        //     Session::forget('user_active_until');
        // }
      
        // if (!Session::has('user_active') || !Session::get('user_active')) {
        //     if ($route && $route->getName() !== 'universal-login') {
        //         return redirect()->route('universal-login', [
        //             'target' => $route->getName(),
        //             // 'id' => $request->input('id')
        //             'id' => $request->route('id') ?? $request->input('id')
        //         ]);
        //     }
        // }
         // Check if the user's session has an active status and the session is not expired
         $route = $request->route();
         

         // Ensure the route is not null before accessing its methods
         if ($route) {
            $routeName = $route->getName();
             // Check if the user's session has an active status and the session is not expired
             $userActive = Session::get('user_active', false);
             $sessionExpiresAt = Session::get('user_active_until');

           

     
             // If the session has expired or user is not marked as active, redirect to universal login
             if (!$userActive || Carbon::now()->greaterThan($sessionExpiresAt)) {
                // dd("hello");
                 // Clear the session if expired
                 Session::forget('user_active');
                 Session::forget('user_active_until');
     
                 // Redirect to the universal login page with target route information
                 return redirect()->route('universal-login');
             } 
            
         }
     

        // if (!Session::has('user_active') || !Session::get('user_active')) {
        //     return redirect()->route('universal-login');
        // }
        
        return $next($request);
    }
}
