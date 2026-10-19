<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

interface OrderCreateRequestExtension extends \JsonSerializable
{
    public function key(): string;
}
