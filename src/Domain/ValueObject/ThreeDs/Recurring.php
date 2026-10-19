<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class Recurring implements \JsonSerializable
{
    public function __construct(
        public string $frequency,
        public string $expiry,
    ) {
        Assert::stringNotEmpty($this->frequency);
        Assert::stringNotEmpty($this->expiry);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'frequency' => $this->frequency,
            'expiry' => $this->expiry,
        ];
    }
}
