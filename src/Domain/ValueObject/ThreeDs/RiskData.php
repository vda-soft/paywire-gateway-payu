<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

final readonly class RiskData implements \JsonSerializable
{
    public function __construct(
        public Browser $browser,
    ) {
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return ['browser' => $this->browser->jsonSerialize()];
    }
}
