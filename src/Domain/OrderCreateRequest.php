<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use PayWire\Core\Domain\Shared\SubmitRequest as CoreSubmitRequest;
use Webmozart\Assert\Assert;

final class OrderCreateRequest implements CoreSubmitRequest
{
    /**
     * @param list<Product> $products
     * @param list<PayMethod> $payMethods
     * @param list<ShoppingCart> $shoppingCarts
     * @param array<string, mixed>|null $settings
     * @param array<string, mixed>|null $mcpData
     * @param array<string, mixed>|null $threeDsAuthentication
     * @param array<string, mixed>|null $riskData
     * @param array<string, mixed>|null $credit
     * @param array<string, mixed>|null $submerchant
     * @param array<string, mixed>|null $deviceFingerprint
     * @param array<string, mixed>|null $donation
     */
    public function __construct(
        public string $customerIp,
        public string $merchantPosId,
        public string $description,
        public string $currencyCode,
        public int $totalAmount,
        public Buyer $buyer,
        /** @var list<Product> */
        public array $products = [],
        public ?string $extOrderId = null,
        public ?string $notifyUrl = null,
        public ?string $continueUrl = null,
        public array $payMethods = [],
        public ?array $settings = null,
        public ?string $additionalDescription = null,
        public ?string $visibleDescription = null,
        public ?string $statementDescription = null,
        public ?int $validityTime = null,
        public ?string $cardOnFile = null,
        public ?string $recurring = null,
        public ?array $donation = null,
        public array $shoppingCarts = [],
        public ?array $mcpData = null,
        public ?array $threeDsAuthentication = null,
        public ?array $riskData = null,
        public ?array $credit = null,
        public ?array $submerchant = null,
        public ?array $deviceFingerprint = null,
    ) {
        Assert::notEmpty($customerIp, 'Customer IP cannot be empty');
        Assert::notEmpty($merchantPosId, 'Merchant POS ID cannot be empty');
        Assert::notEmpty($description, 'Description cannot be empty');
        Assert::notEmpty($currencyCode, 'Currency code cannot be empty');
        Assert::greaterThan($totalAmount, 0, 'Total amount must be positive');
        Assert::notEmpty($products, 'At least one product is required');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'customerIp' => $this->customerIp,
            'merchantPosId' => $this->merchantPosId,
            'description' => $this->description,
            'currencyCode' => $this->currencyCode,
            'totalAmount' => $this->totalAmount,
            'buyer' => $this->buyer->jsonSerialize(),
            'products' => \array_map(static fn (Product $p) => $p->jsonSerialize(), $this->products),
            'notifyUrl' => $this->notifyUrl,
            'continueUrl' => $this->continueUrl,
            'extOrderId' => $this->extOrderId,
            'additionalDescription' => $this->additionalDescription,
            'visibleDescription' => $this->visibleDescription,
            'statementDescription' => $this->statementDescription,
            'validityTime' => $this->validityTime,
            'cardOnFile' => $this->cardOnFile,
            'recurring' => $this->recurring,
            'donation' => $this->donation,
            'shoppingCarts' => [] === $this->shoppingCarts ? null : \array_map(
                static fn (ShoppingCart $sc) => $sc->jsonSerialize(),
                $this->shoppingCarts
            ),
            'payMethods' => [] === $this->payMethods ? null : [
                'payMethod' => \array_map(static fn (PayMethod $pm) => $pm->jsonSerialize(), $this->payMethods),
            ],
            'settings' => $this->settings,
            'mcpData' => $this->mcpData,
            'threeDsAuthentication' => $this->threeDsAuthentication,
            'riskData' => $this->riskData,
            'credit' => $this->credit,
            'submerchant' => $this->submerchant,
            'deviceFingerprint' => $this->deviceFingerprint,
        ];

        return \array_filter($data, static fn (mixed $v): bool => null !== $v);
    }
}
