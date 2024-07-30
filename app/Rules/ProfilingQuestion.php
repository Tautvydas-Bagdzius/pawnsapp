<?php

namespace App\Rules;

use App\Enums\ProfilingQuestionTypes;
use App\Models\ProfilingQuestion as QuestionModel;
use App\Models\ProfilingQuestionAnswer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfilingQuestion implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $question = QuestionModel::where('slug', $attribute)->firstOrFail();

        switch ($question->type) {
            case ProfilingQuestionTypes::SINGLE_CHOICE->value:
            case ProfilingQuestionTypes::MULTIPLE_CHOICE->value: // Multiple would be different irl
                $answers = $question->answers;

                if ($answers->doesntContain('answer', $value)) {
                    $fail('The :attribute is not a valid option.');
                }
                break;

            case ProfilingQuestionTypes::DATE->value:
                if (!strtotime($value)) {
                    $fail('The :attribute is not a date.');
                }
                break;
        }
    }
}
