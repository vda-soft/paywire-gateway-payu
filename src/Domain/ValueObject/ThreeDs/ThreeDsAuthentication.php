<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use PayWire\Gateway\PayU\Domain\Enum\ChallengeRequested;

final readonly class ThreeDsAuthentication implements \JsonSerializable
{
    public function __construct(
        public ?ChallengeRequested $challengeRequested = null,
        public ?Exemption $exemption = null,
        public ?Browser $browser = null,
        public ?Sdk $sdk = null,
        public ?MerchantRiskIndicator $merchantRiskIndicator = null,
        public ?Recurring $recurring = null,
        public ?Cardholder $cardholder = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'challengeRequested' => $this->challengeRequested?->value,
                'exemption' => $this->exemption?->jsonSerialize(),
                'browser' => $this->browser?->jsonSerialize(),
                'sdk' => $this->sdk?->jsonSerialize(),
                'merchantRiskIndicator' => $this->merchantRiskIndicator?->jsonSerialize(),
                'recurring' => $this->recurring?->jsonSerialize(),
                'cardholder' => $this->cardholder?->jsonSerialize(),
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
