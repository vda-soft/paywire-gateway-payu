<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum SourcePaymentFlow: string
{
    case ApplePay = 'APPLE_PAY';
    case Cards = 'CARDS';
    case Mdes = 'MDES';
    case GooglePay = 'GOOGLE_PAY';
    case VisaMobile = 'VISA_MOBILE';
    case Vts = 'VTS';
}
