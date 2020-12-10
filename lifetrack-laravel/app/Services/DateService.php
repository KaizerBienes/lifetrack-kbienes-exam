<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateService {
    public static function isMonthYearValid(int $month, int $year)
    {
        return (Carbon::createFromFormat(('Y-m-01'), "{$year}-{$month}-01") !== false);
    }

    public static function getNumberOfDaysInMonth(int $month, int $year)
    {
        if (self::isMonthYearValid($month, $year)) {
            $dateTime = Carbon::createFromFormat(('Y-m-01'), "{$year}-{$month}-01");
            return $dateTime->daysInMonth;
        } else {
            throw new \InvalidArgumentException('Invalid month year combination.');
        }
    }

    public static function getMonthsListFromMonthYear(int $month, int $year, int $numberOfMonths) : array
    {
        if (self::isMonthYearValid($month, $year)) {
            $startDate = Carbon::createFromDate($year, $month, 1);
            $futureDate = $startDate->copy()->addMonths($numberOfMonths);
            $monthlyPeriods = CarbonPeriod::create($startDate->format('Y-m-d'), $futureDate->format('Y-m-d'))->month();

            return collect($monthlyPeriods)->map(function (Carbon $date) {
                return [
                    'month' => $date->month,
                    'year' => $date->year,
                    'month_year_name' => "{$date->shortMonthName} {$date->year}"
                ];
            })->toArray();
        } else {
            throw new \InvalidArgumentException('Invalid month year combination.');
        }
    }
}