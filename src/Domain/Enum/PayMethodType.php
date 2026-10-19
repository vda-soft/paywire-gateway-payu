<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Enum;

enum PayMethodType: string
{
    case Pbl = 'PBL';
    case CardToken = 'CARD_TOKEN';
    case PaymentWall = 'PAYMENT_WALL';
    case BlikAuthorizationCode = 'BLIK_AUTHORIZATION_CODE';
    case BlikToken = 'BLIK_TOKEN';
    case Transparent = 'TRANSPARENT';
}
