<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Logo;
use App\Models\CassierJudiciaire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(\Config::get('app.app_installed') == 'yes'){
             $logo = Logo::first();
             $citizen = CassierJudiciaire::all();
            
             view()->share(['logo'=>$logo, 'citizen'=>$citizen]);
        }
        
    }
}
