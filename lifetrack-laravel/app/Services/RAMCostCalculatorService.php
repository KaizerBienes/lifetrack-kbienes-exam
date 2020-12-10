<?php

namespace App\Services;

class RAMCostCalculatorService {
    const RAM_MB_NEEDED_PER_1000_STUDIES = 500;
    const STUDIES_SCALE = 1000;
    const RAM_GB_COST_PER_HOUR_IN_USD = 0.00553;
    const GB_TO_MB_SCALE = 1000;
    const HOUR_TO_DAY_SCALE = 24;
    const BCMATH_SCALE = 8;

    public static function getDailyRamCostPerStudy() : float
    {
        $ramPerStudyInMB = bcdiv(
            self::RAM_MB_NEEDED_PER_1000_STUDIES,
            self::STUDIES_SCALE,
            self::BCMATH_SCALE
        );
        $MBOfRamCostPerDay = bcmul(
            bcdiv(
                self::RAM_GB_COST_PER_HOUR_IN_USD,
                self::GB_TO_MB_SCALE,
                self::BCMATH_SCALE
            ),
            self::HOUR_TO_DAY_SCALE,
            self::BCMATH_SCALE
        );

        return bcmul($ramPerStudyInMB, $MBOfRamCostPerDay, self::BCMATH_SCALE);
    }

}