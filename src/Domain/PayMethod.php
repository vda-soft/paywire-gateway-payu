<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use PayWire\Gateway\PayU\Domain\Enum\AuthorizationType;
use PayWire\Gateway\PayU\Domain\Enum\PayMethodType;
use PayWire\Gateway\PayU\Domain\Enum\SourcePaymentFlow;
use PayWire\Gateway\PayU\Domain\ValueObject\BlikData;
use PayWire\Gateway\PayU\Domain\ValueObject\Card;
use PayWire\Gateway\PayU\Domain\ValueObject\CardInstallments;
use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPay;
use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayMastercard;
use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayVisa;
use PayWire\Gateway\PayU\Domain\ValueObject\SpecificData;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsData;
use Webmozart\Assert\Assert;

final readonly class PayMethod implements \JsonSerializable
{
    public const CARD_VALUE = 'c';
    public const BLIK_VALUE = 'blik';

    /**
     * @param list<SpecificData> $specificData
     */
    private function __construct(
        public PayMethodType $type,
        public ?string $value = null,
        public ?string $authorizationCode = null,
        public ?AuthorizationType $authorizationType = null,
        public ?ClickToPay $clickToPay = null,
        public ?Card $card = null,
        public array $specificData = [],
        public ?string $amount = null,
        public ?BlikData $blikData = null,
        public ?ThreeDsData $threeDsData = null,
        public ?SourcePaymentFlow $sourcePaymentFlow = null,
        public ?CardInstallments $cardInstallments = null,
    ) {
        Assert::nullOrStringNotEmpty($this->value);
        Assert::nullOrStringNotEmpty($this->authorizationCode);
        Assert::nullOrStringNotEmpty($this->amount);
        Assert::allIsInstanceOf($this->specificData, SpecificData::class);
    }

    /**
     * @param list<SpecificData> $specificData
     */
    public static function of(
        PayMethodType $type,
        ?string $value = null,
        ?string $authorizationCode = null,
        ?AuthorizationType $authorizationType = null,
        array $specificData = [],
        ?string $amount = null,
        ?CardInstallments $cardInstallments = null,
    ): self {
        return new self(
            type: $type,
            value: $value,
            authorizationCode: $authorizationCode,
            authorizationType: $authorizationType,
            specificData: $specificData,
            amount: $amount,
            cardInstallments: $cardInstallments,
        );
    }

    public static function clickToPayVisa(ClickToPayVisa $visa): self
    {
        return new self(
            type: PayMethodType::Pbl,
            value: self::CARD_VALUE,
            clickToPay: $visa,
        );
    }

    public static function clickToPayMastercard(ClickToPayMastercard $mastercard): self
    {
        return new self(
            type: PayMethodType::Pbl,
            value: self::CARD_VALUE,
            clickToPay: $mastercard,
        );
    }

    public static function digitalWallet(
        Card $card,
        ThreeDsData $threeDsData,
        SourcePaymentFlow $sourcePaymentFlow,
    ): self {
        return new self(
            type: PayMethodType::PaymentWall,
            card: $card,
            threeDsData: $threeDsData,
            sourcePaymentFlow: $sourcePaymentFlow,
        );
    }

    public static function blikRedirect(): self
    {
        return new self(
            type: PayMethodType::Pbl,
            value: self::BLIK_VALUE,
        );
    }

    public static function blikAuthorizationCode(string $code, ?BlikData $blikData = null): self
    {
        Assert::length($code, 6, 'BLIK code must have 6 characters');

        return new self(
            type: PayMethodType::BlikAuthorizationCode,
            value: $code,
            blikData: $blikData,
        );
    }

    public static function blikToken(string $token, ?BlikData $blikData = null): self
    {
        return new self(
            type: PayMethodType::BlikToken,
            value: $token,
            blikData: $blikData,
        );
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type->value,
            'value' => $this->value,
            'authorizationCode' => $this->authorizationCode,
            'authorizationType' => $this->authorizationType?->value,
            'clickToPay' => null === $this->clickToPay ? null : [$this->clickToPay->key() => $this->clickToPay],
            'card' => $this->card,
            'specificData' => [] === $this->specificData ? null : \array_map(
                static fn(SpecificData $specificData): array => $specificData->jsonSerialize(),
                $this->specificData,
            ),
            'amount' => $this->amount,
            'blikData' => $this->blikData,
            'threeDsData' => $this->threeDsData,
            'sourcePaymentFlow' => $this->sourcePaymentFlow?->value,
            'cardInstallments' => $this->cardInstallments,
        ];

        return \array_filter($data, static fn(mixed $value): bool => null !== $value);
    }
}
