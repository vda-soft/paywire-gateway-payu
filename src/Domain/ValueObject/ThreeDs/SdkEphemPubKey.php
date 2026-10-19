<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class SdkEphemPubKey implements \JsonSerializable
{
    public function __construct(
        public string $y,
        public string $x,
        public string $kty,
        public string $crv,
    ) {
        Assert::stringNotEmpty($this->y);
        Assert::stringNotEmpty($this->x);
        Assert::stringNotEmpty($this->kty);
        Assert::stringNotEmpty($this->crv);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'y' => $this->y,
            'x' => $this->x,
            'kty' => $this->kty,
            'crv' => $this->crv,
        ];
    }
}
