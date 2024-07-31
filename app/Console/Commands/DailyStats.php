<?php

namespace App\Console\Commands;

use App\Models\GlobalStats;
use App\Models\Transaction;
use App\Traits\PointsConversion;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyStats extends Command
{
    use PointsConversion;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and Store Daily Global Statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->toDateString();

        $stats = GlobalStats::firstOrCreate([
            'date' => $date,
        ]);

        $numCreated = Transaction::whereDate('created_at', $date)->count();
        $numClaimed = Transaction::whereDate('claimed_at', $date)->count();
        $amountClaimed = Transaction::whereDate('claimed_at', $date)->sum('points');

        $stats->num_transactions_created = $numCreated;
        $stats->num_transactions_claimed = $numClaimed;
        $stats->usd_amount_claimed = $this->pointsToUsd($amountClaimed);

        $stats->save();

        $this->info('Global stats saved to the database');
    }
}
