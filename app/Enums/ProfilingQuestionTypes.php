<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum ProfilingQuestionTypes: string
{
    use EnumValues;

    case MULTIPLE_CHOICE = 'multiple';
    case SINGLE_CHOICE = 'single';
    case DATE = 'date';
}
