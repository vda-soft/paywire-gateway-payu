<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class PayMethod implements \JsonSerializable
{
    /**
     * @param array<string, mixed>|null $clickToPay
     * @param array<string, mixed>|null $card
     * @param list<array<string, mixed>>|null $specificData
     * @param array<string, mixed>|null $blikData
     * @param array<string, mixed>|null $threeDsData
     * @param array<string, mixed>|null $cardInstallments
     */
    public function __construct(
        public string $type,
        public ?string $value = null,
        public ?string $authorizationCode = null,
        public ?string $authorizationType = null,
        public ?array $clickToPay = null,
        public ?array $card = null,
        public ?array $specificData = null,
        public ?string $amount = null,
        public ?array $blikData = null,
        public ?array $threeDsData = null,
        public ?string $sourcePaymentFlow = null,
        public ?array $cardInstallments = null,
    ) {
        Assert::notEmpty($type, 'PayMethod type cannot be empty');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type,
            'value' => $this->value,
            'authorizationCode' => $this->authorizationCode,
            'authorizationType' => $this->authorizationType,
            'clickToPay' => $this->clickToPay,
            'card' => $this->card,
            'specificData' => $this->specificData,
            'amount' => $this->amount,
            'blikData' => $this->blikData,
            'threeDsData' => $this->threeDsData,
            'sourcePaymentFlow' => $this->sourcePaymentFlow,
            'cardInstallments' => $this->cardInstallments,
        ];

        return \array_filter($data, static fn(mixed $v): bool => null !== $v);
    }
}
