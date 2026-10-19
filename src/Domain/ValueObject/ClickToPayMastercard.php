<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class ClickToPayMastercard implements ClickToPay
{
    public function __construct(
        public string $srcCorrelationId,
        public ?string $srcDigitalCardId = null,
    ) {
        Assert::stringNotEmpty($this->srcCorrelationId);
        Assert::nullOrStringNotEmpty($this->srcDigitalCardId);
    }

    public function key(): string
    {
        return 'mastercard';
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'srcCorrelationId' => $this->srcCorrelationId,
                'srcDigitalCardId' => $this->srcDigitalCardId,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
