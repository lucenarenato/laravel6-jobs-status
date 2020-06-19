<?php

namespace App\Jobs;

use App\Services\DummyService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function get_class;

class UserDummyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * @var \App\User
     */
    private $user;
    
    /**
     * Create a new job instance.
     *
     * @param \App\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function tags()
    {
        return ['loggable'];
    }
    
    public function handle(DummyService $service)
    {
        $service->dummyJobLogic(2, 1);
    }
    
    public function displayName()
    {
        return get_class($this->user) . ':' . $this->user->id;
    }
}