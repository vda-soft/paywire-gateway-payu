<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class ShoppingCart implements \JsonSerializable
{
    /**
     * @param list<Product> $products
     * @param list<ShippingMethod> $shippingMethods
     */
    public function __construct(
        public ?string $extCustomerId = null,
        public ?int $amount = null,
        public ?int $fee = null,
        public array $shippingMethods = [],
        public array $products = [],
    ) {
        Assert::nullOrGreaterThan($amount, -1, 'Amount cannot be negative');
        Assert::nullOrGreaterThan($fee, -1, 'Fee cannot be negative');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'extCustomerId' => $this->extCustomerId,
            'amount' => $this->amount,
            'fee' => $this->fee,
            'shippingMethods' => [] === $this->shippingMethods ? null : \array_map(
                static fn (ShippingMethod $sm) => $sm->jsonSerialize(),
                $this->shippingMethods
            ),
            'products' => [] === $this->products ? null : \array_map(
                static fn (Product $p) => $p->jsonSerialize(),
                $this->products
            ),
        ];

        return \array_filter($data, static fn (mixed $v): bool => null !== $v);
    }
}
