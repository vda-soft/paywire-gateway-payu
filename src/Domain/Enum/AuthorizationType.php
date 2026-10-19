<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum AuthorizationType: string
{
    case PreAuthorization = 'PRE_AUTHORIZATION';
    case Authorization = 'AUTHORIZATION';
}
