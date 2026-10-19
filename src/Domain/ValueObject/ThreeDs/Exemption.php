<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use PayWire\Gateway\PayU\Domain\Enum\ExemptionValue;
use PayWire\Gateway\PayU\Domain\Enum\RejectionHandling;
use Webmozart\Assert\Assert;

final readonly class Exemption implements \JsonSerializable
{
    public function __construct(
        public ExemptionValue $value,
        public RejectionHandling $rejectionHandling,
        public ?string $riskScore = null,
    ) {
        Assert::nullOrMaxLength($this->riskScore, 128);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'value' => $this->value->value,
                'rejectionHandling' => $this->rejectionHandling->value,
                'riskScore' => $this->riskScore,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
