<?php

namespace App\Enums;

use Carbon\CarbonPeriod;

enum TimeBreakdown: string
{
    case TODAY = "t";
    case WEEK = "w";
    case MONTH = "m";
    case YEAR = "y";

    public function getPeriod(): CarbonPeriod
    {
        return match ($this) {
            self::TODAY => CarbonPeriod::between(now()->startOfDay(), now()->endOfDay()),
            self::WEEK => CarbonPeriod::between(now()->startOfWeek(), now()->endOfWeek()),
            self::MONTH => CarbonPeriod::between(now()->startOfMonth(), now()->endOfMonth()),
            self::YEAR => CarbonPeriod::between(now()->startOfYear(), now()->endOfYear()),
        };
    }


    public function getText() {
        return match ($this) {
            self::TODAY => "Today",
            self::WEEK => "This Week",
            self::MONTH => "This Month",
            self::YEAR => "This Year"
        };
    }


}
