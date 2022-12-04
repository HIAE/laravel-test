<?php

namespace App\Constants;

class IdeaStatus
{
    const CREATED = 'nova';
    const IN_ANALYSIS = 'em análise';
    const IN_PROGRESS = 'em progresso';
    const IMPLEMENTED = 'implementada';
    const CLOSED = 'fechada';

    public static function getAvailableStatus(): array
    {
        return [
            self::CREATED,
            self::IN_ANALYSIS,
            self::IN_PROGRESS,
            self::IMPLEMENTED,
            self::CLOSED
        ];
    }
}
