<?php

namespace App\Services;

use Carbon\Carbon;

class StudyTrackerService {
    const BCMATH_SCALE = 8;

    public function __construct(TotalMonthlyCostCalculatorService $totalMonthlyCostCalculatorService)
    {
        $this->totalMonthlyCostCalculatorService = $totalMonthlyCostCalculatorService;
    }

    public function calculateEstimates(float $studyPerDay, float $growthPerMonth, int $monthsToForecast) {
        $currentDate = Carbon::now();
        $monthYearList = DateService::getMonthsListFromMonthYear(
            $currentDate->month,
            $currentDate->year,
            $monthsToForecast
        );

        $forecastResults = [];
        $monthYearsCount = count($monthYearList);
        $currentStudyPerDay = $studyPerDay;
        for ($counter = 0; $counter < $monthYearsCount; $counter++) {
            $month = $monthYearDetails['month'] ?? 0;
            $year = $monthYearDetails['year'] ?? 0;
            $daysCurrentMonth = DateService::getNumberOfDaysInMonth($month, $year);

            // calculate forecast and load into the results
            $forecastResults[] = $this->calculateForecastResult(
                $currentStudyPerDay,
                $monthYearList[$counter],
                $daysCurrentMonth
            );

            // calculate next month's study per day
            if ($counter !== $monthYearsCount - 1) {
                $nextMonth = $monthYearList[$counter+1]['month'] ?? 0;
                $nextYear = $monthYearList[$counter+1]['year'] ?? 0;
                $daysNextMonth = DateService::getNumberOfDaysInMonth($nextMonth, $nextYear);
                $currentStudyPerDay = $this->getNextMonthStudyPerDay(
                    $currentStudyPerDay,
                    $daysCurrentMonth,
                    $daysNextMonth,
                    $growthPerMonth
                );
            }
        }

        return $forecastResults;
    }

    protected function calculateForecastResult(float $currentStudyPerDay, array $monthYearDetails, int $daysCurrentMonth)
    {
        $totalMonthlyCost = $this->totalMonthlyCostCalculatorService->calculateTotalMonthlyCost(
            $currentStudyPerDay,
            $monthYearDetails['month'] ?? 0,
            $monthYearDetails['year'] ?? 0
        );

        return [
            'month_year' => $monthYearDetails['month_year_name'],
            'studies_per_day' => $currentStudyPerDay,
            'total_studies' => bcmul($daysCurrentMonth, $currentStudyPerDay, self::BCMATH_SCALE),
            'cost_forecasted_in_usd' => $totalMonthlyCost,
        ];
    }

    protected function getNextMonthStudyPerDay(float $studyPerDay, int $daysCurrentMonth, int $daysNextMonth, float $growthPerMonth)
    {
        $studyPerMonth = bcmul($studyPerDay, $daysCurrentMonth, self::BCMATH_SCALE);

        $scaledNumberOfStudiesPerMonth = bcmul(
            $studyPerMonth,
            bcdiv(
                bcadd($growthPerMonth, 100, self::BCMATH_SCALE),
                100,
                self::BCMATH_SCALE
            ),
            self::BCMATH_SCALE
        );

        return bcdiv($scaledNumberOfStudiesPerMonth, $daysNextMonth, self::BCMATH_SCALE);
    }
}