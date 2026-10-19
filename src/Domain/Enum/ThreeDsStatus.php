<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum ThreeDsStatus: string
{
    case Successful = 'Y';
    case Attempt = 'A';
}
