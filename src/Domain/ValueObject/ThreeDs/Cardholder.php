<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class Cardholder implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public ?AccountInformation $accountInformation = null,
        public ?BillingAddress $billingAddress = null,
    ) {
        Assert::stringNotEmpty($this->name);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'name' => $this->name,
                'accountInformation' => $this->accountInformation?->jsonSerialize(),
                'billingAddress' => $this->billingAddress?->jsonSerialize(),
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
