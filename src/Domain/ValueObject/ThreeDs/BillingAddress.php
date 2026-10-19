<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class BillingAddress implements \JsonSerializable
{
    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public string $state,
        public string $countryCode,
    ) {
        Assert::stringNotEmpty($this->street);
        Assert::stringNotEmpty($this->postalCode);
        Assert::stringNotEmpty($this->city);
        Assert::stringNotEmpty($this->state);
        Assert::stringNotEmpty($this->countryCode);
        Assert::maxLength($this->city, 50);
        Assert::maxLength($this->state, 3);
        Assert::regex($this->countryCode, '/^[A-Z]{2}$/');
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'street' => $this->street,
            'postalCode' => $this->postalCode,
            'city' => $this->city,
            'state' => $this->state,
            'countryCode' => $this->countryCode,
        ];
    }
}
