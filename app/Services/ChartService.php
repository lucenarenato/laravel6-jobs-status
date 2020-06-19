<?php namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Repositories\UsersRepositoryInterface;

/**
 * Class ChartService
 * @package App\Services
 */
class ChartService
{
    /**
     * @var \App\Repositories\UsersRepositoryInterface
     */
    protected $users;

    /**
     * @param  \App\Repositories\UsersRepositoryInterface  $users
     */
    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Collect groups for all weeks.
     * @param $usersByWeek
     * @return \Illuminate\Support\Collection
     */
    public function getGroupsForAllWeeks($usersByWeek): Collection
    {
        return collect($usersByWeek)->map(
            function ($users) {
                return $this->getPeriodGroup($users);
            }
        )->values();
    }

    /**
     * Generates the data for a period.
     *
     * @param $periodUsers
     * @return array
     */
    public function getPeriodGroup($periodUsers): array
    {
        return [
            'name' => $this->getPeriodName($periodUsers->first()['created_at']),
            'data' => $this->calculatePercentages($periodUsers),
        ];
    }

    /**
     * Count the users that are on the current onboarding percentage.
     *
     * @param $percentage
     * @param $percentagesOfUsers
     * @return int
     */
    public function numberOfUsersInPercentage($percentage, $percentagesOfUsers)
    {
        // Strip the users that are not on current percentage and count
        return collect($percentagesOfUsers)->reject(
            function ($percentageOfUser) use ($percentage) {
                return $percentageOfUser <= $percentage;
            }
        )->count();
    }

    /**
     * Calculates the percentages.
     *
     * @param $usersInPeriod
     * @return Collection
     */
    private function calculatePercentages($usersInPeriod)
    {
        // Get all onboarding percentages
        $onboardingPercentages = $usersInPeriod->pluck('onboarding_percentage')->all();

        // Fill the percentages in a range from 0 - 100
        return Collection::times(100, function ($currentPercentage) use ($usersInPeriod, $onboardingPercentages) {
                $numberOfUsers = $this->numberOfUsersInPercentage($currentPercentage, $onboardingPercentages);
                return round($numberOfUsers / count($usersInPeriod) * 100, 2);
            }
        );
    }

    /**
     * Gets the monday of the week from given date.
     * @param  string  $date
     * @return string
     */
    public function getPeriodName($date): string
    {
        return Carbon::parse($date)->startOfWeek()->toDateString();
    }

    /**
     * Collect all data in the right format for the chart
     * @return \Illuminate\Support\Collection
     */
    public function getChartData()
    {
        return $this->getGroupsForAllWeeks(
            $this->users->groupedByWeek()
        );
    }
}
