<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum RejectionHandling: string
{
    case PerformAuthentication = 'PERFORM_AUTHENTICATION';
    case Decline = 'DECLINE';
}
