<?php

namespace App\Console\Commands;

use App\Enums\ProfilingQuestionTypes;
use App\Models\ProfilingQuestion;
use App\Models\ProfilingQuestionAnswer;
use Illuminate\Console\Command;

class PrepopulateProfilingQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepopulate-profiling-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepopulate Database with profiling questions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->insertGender();
        $this->insertDateOfBirth();
    }

    /**
     * Inserts gender question if not already present
     */
    private function insertGender(): void
    {
        $gender = ProfilingQuestion::firstOrCreate([
            'question' => 'Gender',
            'slug' => 'gender',
            'type' => ProfilingQuestionTypes::SINGLE_CHOICE,
        ]);

        if ($gender->wasRecentlyCreated) {
            $male = new ProfilingQuestionAnswer();
            $male->profiling_question_id = $gender->id;
            $male->answer = 'Male';

            $female = new ProfilingQuestionAnswer();
            $female->profiling_question_id = $gender->id;
            $female->answer = 'Female';

            $male->save();
            $female->save();
        }
    }

    /**
     * Inserts "date of birth" question if not already present
     */
    private function insertDateOfBirth(): void
    {
        ProfilingQuestion::firstOrCreate([
            'question' => 'Date of birth',
            'slug' => 'date_of_birth',
            'type' => ProfilingQuestionTypes::DATE,
        ]);
    }
}
