<?php

namespace App\Lib\InteractiveJobs;

use App\Lib\InteractiveJobs\Contracts\JobDefinitionRepository;
use App\Lib\InteractiveJobs\Models\Job;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Laravel\Horizon\JobPayload;

class InteractiveJobsProvider extends ServiceProvider
{
    public function boot()
    {
        app(QueueManager::class)->before(function (JobProcessing $event) {
            $payload = new JobPayload($event->job->getRawBody());
            if(Str::contains($payload->displayName(), ':')){
                $relation = explode(':', $payload->displayName());
                $context = new JobContext($relation[1], $relation[0]);
            }else{
                $context = new JobContext($payload->id(), $payload->commandName());
            }
            
            if (in_array('loggable', $payload->tags())) {
                Config::set('jobs.context', $context);
            }
        });
        
        // Job::observe(JobModelObserver::class);
        // View::composer(['jobs._menu'], JobMenuComposer::class);
    }
    
    public function provides()
    {
        return [JobDefinitionRepository::class];
    }
    
    public function register()
    {
        $this->app->singleton(JobDefinitionRepository::class, JobDefinitionConfigRepository::class);
    }
}
