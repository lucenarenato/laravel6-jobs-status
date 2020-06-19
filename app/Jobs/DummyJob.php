<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lib\InteractiveJobs\InteractiveJob;
use App\Lib\InteractiveJobs\Notifications\LogMessage;
use App\Lib\InteractiveJobs\Notifications\Progress;
use App\Services\DummyService;
use function array_random;
use function usleep;
use Illuminate\Support\Facades\Log;
use Imtigger\LaravelJobStatus\Trackable;

class DummyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params = [])
    {
        $this->prepareStatus();
        $this->params = $params;
        $this->setInput($this->params);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DummyService $service)
    {
        $max = mt_rand(5, 30);
        $this->setProgressMax($max);

        for ($i = 0; $i <= $max; $i += 1) {
            sleep(1); // Some Long Operations
            $this->setProgressNow($i);
        }

        $this->setOutput(['total' => $max, 'other' => 'parameter']);
        
        $payload = $this->jobModel->payload;
        $service->setCallback(function ($i, $loop) {
            $ratio = round($i*100/$loop);
            $this->jobModel->notifyNow(new Progress($ratio));
            usleep(300);
            $this->jobModel->notifyNow(new LogMessage(array_random(['apple', 'banana','orange','melon']).' job message'));
        })->dummyJobLogic($payload['loop'] ?? 3, $payload['delay'] ?? 1);

        // $service->dummyJobLogic(
        //     $this->params['loop'], $this->params['delay']
        // );
    }
}
