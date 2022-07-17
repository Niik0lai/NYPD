<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;

class CheckInstalledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       try {
            \DB::connection()->getPdo();
          } catch (\Exception $e) {
            return redirect('install');
          }

        if (Schema::hasTable('users') && \Config::get('app.app_installed') == 'yes') {
           
            return $next($request);
        }
     
        return redirect('install');
    }
}
