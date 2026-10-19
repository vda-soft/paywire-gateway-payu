<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\Extension;

use PayWire\Gateway\PayU\Domain\OrderCreateRequestExtension;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\RiskData;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsAuthentication;
use Webmozart\Assert\Assert;

final readonly class ThreeDsExtension implements OrderCreateRequestExtension
{
    public function __construct(
        public ?ThreeDsAuthentication $threeDsAuthentication = null,
        public ?RiskData $riskData = null,
        public ?string $deviceFingerprint = null,
    ) {
        Assert::nullOrMaxLength($this->deviceFingerprint, 255);
    }

    public function key(): string
    {
        return 'three_ds';
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'threeDsAuthentication' => $this->threeDsAuthentication?->jsonSerialize(),
                'riskData' => $this->riskData?->jsonSerialize(),
                'deviceFingerprint' => $this->deviceFingerprint,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
