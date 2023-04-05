<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachingStaffsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( Auth::user()->role == 'Head Master' || Auth::user()->role == 'Second Master'
        || Auth::user()->role == 'Accountant' || Auth::user()->role == 'Academic'
        || Auth::user()->role == 'Sport Teacher' || Auth::user()->role == 'Discipline'
        || Auth::user()->role == 'Normal Teacher') {
    
            return $next($request);
        } else {
            return back()->with('error','You are not authorized to perform this action');
        }
        
    }
}
