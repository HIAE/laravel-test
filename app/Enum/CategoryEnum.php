<?php

namespace App\Enum;

enum CategoryEnum: string
{
    case CLOSED = 'closed';
    case IMPLEMENTED = 'implemented';
    case IN_PROGRESS = 'in progress';
    case NEW = 'new';
    case UNDER_REVIEW = 'under_review';
}
