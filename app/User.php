<?php

namespace App;

use App\Lib\InteractiveJobs\Models\Job;
use App\Lib\InteractiveJobs\Models\JobLog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if the authenticated user is an admin or not
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->attributes['type'], [
            'admin'
        ]);
    }

    public function logs()
    {
        return $this->morphMany(JobLog::class, 'loggable');
    }
    
    public function jobs()
    {
        return $this->hasMany(Job::class, 'created_by');
    }
    
    public function hasJob($jobId):bool
    {
        return $this->jobs()->where('id', $jobId)->exists();
    }
}
