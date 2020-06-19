<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class StartDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    protected $deployment;
    protected $trackedJob;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deployment)
    {
        $this->deployment = $deployment;
        $this->trackedJob = $this->deployment->steps->create([
            'name' => 'StartDeployment',
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->trackedJob->markAsStarted();

        try {
            $this->deployment->markAsInProgress();

            $this->trackedJob->markAsFinished('Optional job output here...'); //$this->trackedJob->markAsFinished();
        } catch (Throwable $e) {
            $this->fail($e);
        }
    }

    public function failed()
    {
        $this->deployment->markAsFailed();
        $this->trackedJob->markAsFailed($exception->getMessage()); //$this->trackedJob->markAsFailed();
    }

    /**
     * Did you know? Traits allow you to define an abstract method, requiring
     * classes to implement them.
     */
    //abstract function execute();

    // StartDeployment.php

    public function execute()
    {
        $this->model->markAsInProgress();

        return true;
    }
}
