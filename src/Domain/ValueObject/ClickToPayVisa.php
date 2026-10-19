<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class ClickToPayVisa implements ClickToPay
{
    public function __construct(
        public string $srcCorrelationId,
    ) {
        Assert::stringNotEmpty($this->srcCorrelationId);
    }

    public function key(): string
    {
        return 'visa';
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return ['srcCorrelationId' => $this->srcCorrelationId];
    }
}
