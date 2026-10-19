<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class SpecificData implements \JsonSerializable
{
    public function __construct(
        public ?string $name = null,
        public ?string $value = null,
    ) {
        Assert::nullOrStringNotEmpty($this->name);
        Assert::nullOrStringNotEmpty($this->value);
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'name' => $this->name,
                'value' => $this->value,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
