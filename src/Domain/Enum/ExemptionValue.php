<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum ExemptionValue: string
{
    case LowRisk = 'LOW_RISK';
    case LowValue = 'LOW_VALUE';
}
