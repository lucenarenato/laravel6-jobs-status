<?php namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class ChartTest
 * @package Tests\Feature
 */
class ChartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testChartRoute()
    {
        $response = $this->get('/chart');
        $response->assertStatus(200);
    }

    public function testChartTitleIsVisible()
    {
        $response = $this->get('/chart');
        $response->assertSee('Temper Assessment: Weekly Retention');
    }

    public function testChartHasSeriesData()
    {
        $response = $this->get('/chart');
        $response->assertSee('<chart-component :series=\'[{"name":"');
    }

    public function testViewHasData()
    {
        $response = $this->get('/chart');
        $this->assertNotEmpty($response->viewData('chartData'));
    }

    public function testViewDataIsValidJson()
    {
        $response = $this->get('/chart');
        $this->assertJson($response->viewData('chartData'));
    }
}
