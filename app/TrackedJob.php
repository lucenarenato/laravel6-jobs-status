<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackedJob extends Model
{
    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';

    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function trackable()
    {
        return $this->morphTo('trackable');
    }

    public function markAsStarted()
    {
        $this->update([
            'status' => static::STATUS_STARTED,
            'started_at' => now(),
        ]);
    }

    public function markAsFinished($output = '')
    {
        $this->update([
            'status' => static::STATUS_FINISHED,
            'finished_at' => now(),
        ]);
        $this->setOutput($output);
    }

    public function setOutput($output)
    {
        $this->update(['output' => $output]);
    }

    public function markAsFailed($exception)
    {
        $this->update([
            'status' => static::STATUS_FAILED,
            'finished_at' => now(),
        ]);

        $this->setOutput($exception);

        if (method_exists($this->trackable, 'markAsFailed')) {
            $this->trackable->markAsFailed();
        }
    }
    /**
     * Get the duration of the job, in human diff.
     *
     * @return string
     */
    public function duration()
    {
        if (!$this->hasStarted()) return '';

        return ($this->finished_at ?? now())
            ->diffAsCarbonInterval($this->started_at)
            ->forHumans(['short' => true]);
    }

    /**
     * Get a pretty formatted label based on the name of the job.
     *
     * @return string
     */
    public function label(): string
    {
        return str_replace('-', ' ', Str::title(Str::kebab($this->name)));
    }
}
