<?php

namespace App\Providers;

use DB;
use App\Lib\InteractiveJobs\Contracts\JobDefinitionRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
        //$this->app->register(RepositoryServiceProvider::class);
        //$this->app->register(JobDefinitionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // debug de query local em densenvolvimento.
        if (env('APP_URL') == 'http://localhost') {
            DB::listen(function ($query) {
                if (preg_match('/^select/', $query->sql)) {
                    Log::info('sql: ' .  $query->sql);
                    // Also available are $query->bindings and $query->time.
                }
                //Log::info($query->bindings, $query->time);
            });
        }
    }
}
