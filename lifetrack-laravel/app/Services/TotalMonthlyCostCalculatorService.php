<?php

namespace App\Services;

use App\Services\DateService;
use App\Services\RAMCostCalculatorService;
use App\Services\StorageCostCalculatorService;

class TotalMonthlyCostCalculatorService {
    protected $dailyRamCostPerStudy;

    protected $monthlyStorageCostPerStudy;

    const BCMATH_SCALE = 8;

    public function __construct()
    {
        // convert to string for bcmath to retain significant digits
        $this->dailyRamCostPerStudy = number_format(
            RAMCostCalculatorService::getDailyRamCostPerStudy(),
            self::BCMATH_SCALE,
            '.',
            ''
        );
        $this->monthlyStorageCostPerStudy = number_format(
            StorageCostCalculatorService::getMonthlyStorageCostPerStudy(),
            self::BCMATH_SCALE,
            '.',
            ''
        );
    }

    public function calculateTotalMonthlyCost(float $numberOfStudies, int $month, int $year)
    {
        if (!DateService::isMonthYearValid($month, $year)) {
            throw new \InvalidArgumentException('Invalid month year combination.');
        } else {
            $numberOfDaysInMonth = DateService::getNumberOfDaysInMonth($month, $year);


            $totalRamCost = bcmul(
                bcmul(
                    $this->dailyRamCostPerStudy,
                    $numberOfStudies,
                    self::BCMATH_SCALE
                ),
                $numberOfDaysInMonth,
                self::BCMATH_SCALE
            );

            $totalStorageCost = bcmul(
                $this->monthlyStorageCostPerStudy,
                $numberOfStudies,
                self::BCMATH_SCALE
            );

            return [
                'ram_cost' => $totalRamCost,
                'storage_cost' => $totalStorageCost,
                'total_cost' => bcadd(
                    $totalRamCost,
                    $totalStorageCost,
                    self::BCMATH_SCALE
                )
            ];
        }
    }
}