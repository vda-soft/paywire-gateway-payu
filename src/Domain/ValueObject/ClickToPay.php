<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

interface ClickToPay extends \JsonSerializable
{
    public function key(): string;
}
