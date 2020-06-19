<?php

namespace App\Jobs;

use App\Jobs\Middleware\Tracked;
use App\TrackedJob;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Support\Facades\Log;
use Throwable;

trait Trackable
{
    /**
     * The model associated with the job.
     */
    public $model;

    /**
     * TrackedJob tied to this job.
     *
     * @var \App\TrackedJob
     */
    public $trackedJob;

    public function __construct($model)
    {
        $this->model = $model;

        $this->trackedJob = TrackedJob::create([
            'trackable_id' => $this->model->id,
            'trackable_type' => get_class($this->model),
            'name' => class_basename(static::class),
        ]);
    }

    public function handle()
    {
        $this->trackedJob->markAsStarted();

        try {
            // NOTE: execute() must be implemented by the class using the trait
            $response = $this->execute();

            // If response is truthy, mark it as finished. This allows for cases
            // where the job is released and the status shouldn't yet be updated.
            if ($response) {
                $this->trackedJob->markAsFinished($response);
            }
        } catch (Throwable $e) {
            $this->fail($e);
        }
    }

    public function middleware()
    {
        return [new Tracked];
    }

    public function appendToFailureOutput(): string
    {
        return '';
    }

    /**
     * Handle the job failing by marking the deployment as failed.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::error($exception->getMessage());

        $message = $exception->getMessage();

        if ($exception instanceof MaxAttemptsExceededException) {
            $message = 'This operation took too long.';
        }

        $this->trackedJob->markAsFailed($message . PHP_EOL . $this->appendToFailureOutput());
    }
}