<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class Product implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public int $unitPrice,
        public int $quantity = 1,
        public ?bool $virtual = null,
    ) {
        Assert::notEmpty($name, 'Product name cannot be empty');
        Assert::greaterThan($unitPrice, -1, 'Unit price cannot be negative');
        Assert::greaterThan($quantity, 0, 'Quantity must be positive');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'name' => $this->name,
            'unitPrice' => $this->unitPrice,
            'quantity' => $this->quantity,
            'virtual' => $this->virtual,
        ];

        return \array_filter($data, static fn (mixed $v): bool => null !== $v);
    }
}
