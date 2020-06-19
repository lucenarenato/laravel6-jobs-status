<?php 

namespace App\Http\Controllers;

use App\Services\ChartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/**
 * Class StatisticsController
 * @package App\Http\Controllers
 */
class ChartController extends Controller
{
    /**
     * @param  \App\Services\ChartService  $service
     * @return string
     */
    public function index(ChartService $service)
    {
        // Return data to view
        return view(
            'chart', [
                'chartData' => $service->getChartData(),
            ]
        );
    }
}
