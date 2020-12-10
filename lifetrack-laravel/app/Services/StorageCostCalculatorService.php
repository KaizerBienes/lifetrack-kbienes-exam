<?php

namespace App\Services;

class StorageCostCalculatorService {
    const STORAGE_MB_PER_STUDY = 10;
    const STORAGE_GB_COST_PER_MONTH_IN_USD = 0.10;
    const GB_TO_MB_SCALE = 1000;
    const BCMATH_SCALE = 8;

    public static function getMonthlyStorageCostPerStudy() : float
    {
        $monthlyStorageInMBCost = bcdiv(
            self::STORAGE_GB_COST_PER_MONTH_IN_USD,
            self::GB_TO_MB_SCALE,
            self::BCMATH_SCALE
        );

        return bcmul(
            $monthlyStorageInMBCost,
            self::STORAGE_MB_PER_STUDY,
            self::BCMATH_SCALE
        );
    }

}