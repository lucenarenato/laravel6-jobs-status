<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ChartService;
use App\Repositories\UsersRepository;

class ChartDataTest extends TestCase
{
    protected $statisticsService;

    public function setUp(): void
    {
        parent::setUp();

        $this->statisticsService = new ChartService(
            new UsersRepository()
        );
    }

    /**
     * Test the calculation of users per percentage
     */
    public function testCalculateUsersInPercentage()
    {
        $percentagePerUser = [10, 10, 20, 30, 30, 50, 90, 99];
        $this->assertEquals(5, $this->statisticsService->numberOfUsersInPercentage(29, $percentagePerUser));
    }

    /**
     * Test the period-name of a date
     */
    public function testGetPeriodName()
    {
        $this->assertEquals('2019-12-09', $this->statisticsService->getPeriodName('2019-12-14'));
    }
}
