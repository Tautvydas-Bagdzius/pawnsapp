<?php

namespace App\Traits;

trait PointsConversion
{
    public function pointsToUsd(int $points): string
    {
        return number_format($points / 100, 2);
    }
}
