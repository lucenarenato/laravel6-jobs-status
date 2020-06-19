<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/**
 * Class StatisticsController
 * @package App\Http\Controllers
 */
class YourController extends Controller {
    use DispatchesJobs;

    function go() {
        $job = new TrackableJob([]);
        $this->dispatch($job);

        $jobStatusId = $job->getJobStatusId();
    }
}