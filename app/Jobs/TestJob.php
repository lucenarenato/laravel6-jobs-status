<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Imtigger\LaravelJobStatus\Trackable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    public $monkeys;

    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($monkeys)
    {
        $this->prepareStatus();
        $this->monkeys = 12;
        //$this->queue = 'high';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $max = mt_rand(5, 30);
        $this->setProgressMax($max);

        for ($i = 0; $i <= $max; $i += 1) {
            sleep(1); // Some Long Operations
            $this->setProgressNow($i);
        }

        $this->setOutput(['total' => $max, 'other' => 'parameter']);

        /*$job = new TrackableJob([]);
        $this->dispatch($job);
        return view('progress', [$job->getJobStatusId()]);*/

        //return redirect()->action('\Imtigger\LaravelJobStatus\ProgressController@progress', [$job->getJobStatusId()]);

        Log::info("Hello, job! Attempts: {$this->attempts()}");

        // $this->release(5);
    }
}
