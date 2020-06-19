<?php

namespace App\Lib\InteractiveJobs\Logger;

use function config;
use Monolog\Logger;

class JobLogger
{
    public function __invoke()
    {
        $monolog = new Logger('job_logger');
        $level = config('logging.channels.custom.level');
        $handler = new JobLogDbHandler(config('logging.channels.custom.level'));
        $monolog->pushHandler($handler);
        return $monolog;
    }
}
