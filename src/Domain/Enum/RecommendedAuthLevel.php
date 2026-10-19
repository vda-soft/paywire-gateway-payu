<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum RecommendedAuthLevel: string
{
    case NoConfirmation = 'NO_CONFIRMATION';
    case RequiredConfirmation = 'REQUIRED_CONFIRMATION';
}
