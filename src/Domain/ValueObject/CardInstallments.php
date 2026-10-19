<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class CardInstallments implements \JsonSerializable
{
    public function __construct(
        public ?string $provider = null,
        public ?string $number = null,
    ) {
        Assert::nullOrStringNotEmpty($this->provider);
        Assert::nullOrStringNotEmpty($this->number);
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'provider' => $this->provider,
                'number' => $this->number,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
