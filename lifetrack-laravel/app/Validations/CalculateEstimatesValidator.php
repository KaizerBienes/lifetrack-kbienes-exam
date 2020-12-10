<?php

namespace App\Validations;

class CalculateEstimatesValidator extends BaseValidator {
    public static function getRules()
    {
        return [
            'spd' => ['required', 'numeric', 'min:1'],
            'gpm' => ['required', 'numeric', 'min:0.01'],
            'mtf' => ['required', 'numeric', 'min:1'],
        ];
    }

    public static function getMessages()
    {
        return [
        ];
    }

    public static function getAttributes()
    {
        return [
            'spd' => 'Number of study per day',
            'gpm' => 'Number of study growth per month (%)',
            'mtf' => 'Months to forecast'
        ];
    }
}