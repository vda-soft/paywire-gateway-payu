<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class ShippingMethod implements \JsonSerializable
{
    public function __construct(
        public string $country,
        public int $price,
        public string $name,
    ) {
        Assert::notEmpty($country, 'Country cannot be empty');
        Assert::greaterThan($price, -1, 'Price cannot be negative');
        Assert::notEmpty($name, 'Name cannot be empty');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'country' => $this->country,
            'price' => $this->price,
            'name' => $this->name,
        ];
    }
}
