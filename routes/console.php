<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\DailyStats;

Schedule::command(DailyStats::class)->daily();