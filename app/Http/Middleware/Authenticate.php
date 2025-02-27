<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
    
    // // For Competitive Exam
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('mock.login');
    // }

    protected function redirectTo(Request $request): ?string
    {
        // If user is accessing mock test, redirect to mock login
        if ($request->is('mock-test') || $request->is('mock-test/*')) {
            return route('mock.login');
        }

        // Default Laravel login for other cases
        return $request->expectsJson() ? null : route('login');
    }
}
