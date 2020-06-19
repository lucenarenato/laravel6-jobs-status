<?php namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\LazyCollection;

/**
 * Class UsersRepository
 * @package App\Repositories
 */
class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @var \Illuminate\Support\LazyCollection
     */
    protected $users;

    /**
     * Load data from CSV file into a LazyCollection
     */
    public function __construct()
    {
        $this->users = LazyCollection::make(
            function () {
                $handle = fopen(storage_path('export.csv'), 'r');
                while ($row = fgetcsv($handle, 0, ';')) {
                    yield $row;
                }
            })
            ->skip(1)
            ->map(function ($row) {
                    return [
                        'created_at'            => Carbon::createFromFormat('Y-m-d', $row[1]),
                        'onboarding_percentage' => intval($row[2]),
                    ];
                }
            );
    }

    /**
     * Group all rows by week number from the lazy collection
     * and format it to a normal collection.
     * @return \Illuminate\Support\Collection
     */
    public function groupedByWeek()
    {
        return $this->users->groupBy(
            function ($user) {
                return $user['created_at']->format('W');
            }
        )->collect();
    }
}
