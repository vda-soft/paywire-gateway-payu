<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum ChallengeRequested: string
{
    case Yes = 'YES';
    case No = 'NO';
    case Mandate = 'MANDATE';
}
