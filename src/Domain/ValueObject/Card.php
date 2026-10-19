<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class Card implements \JsonSerializable
{
    public function __construct(
        public ?string $number = null,
        public ?string $expirationMonth = null,
        public ?string $expirationYear = null,
        public ?string $cvv = null,
        public ?string $firstTransactionId = null,
    ) {
        Assert::nullOrStringNotEmpty($this->number);
        Assert::nullOrStringNotEmpty($this->expirationMonth);
        Assert::nullOrStringNotEmpty($this->expirationYear);
        Assert::nullOrStringNotEmpty($this->cvv);
        Assert::nullOrStringNotEmpty($this->firstTransactionId);
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'number' => $this->number,
                'expirationMonth' => $this->expirationMonth,
                'expirationYear' => $this->expirationYear,
                'cvv' => $this->cvv,
                'firstTransactionId' => $this->firstTransactionId,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
