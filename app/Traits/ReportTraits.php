<?php

namespace App\Traits;

use Carbon\Carbon;

trait ReportTraits {

    private function getFromDate()
    {
        $request = \request();
        $paramDate = $request->get('d');

        $array = [
            '1d' => Carbon::now()->subDays(),
            '1w' => Carbon::now()->subDays(7),
            '2w' => Carbon::now()->subDays(14),
            '1m' => Carbon::now()->subDays(30),
            '3m' => Carbon::now()->subDays(90),
            '6m' => Carbon::now()->subDays(180),
        ];

        return $array[$paramDate] ?? null;
    }
}
