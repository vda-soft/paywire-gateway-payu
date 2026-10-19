<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\Domain;

use PayWire\Gateway\PayU\Domain\Enum\AuthorizationType;
use PayWire\Gateway\PayU\Domain\Enum\BlikCountryCode;
use PayWire\Gateway\PayU\Domain\Enum\PayMethodType;
use PayWire\Gateway\PayU\Domain\Enum\SourcePaymentFlow;
use PayWire\Gateway\PayU\Domain\PayMethod;
use PayWire\Gateway\PayU\Domain\ValueObject\BlikData;
use PayWire\Gateway\PayU\Domain\ValueObject\Card;
use PayWire\Gateway\PayU\Domain\ValueObject\CardInstallments;
use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayMastercard;
use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayVisa;
use PayWire\Gateway\PayU\Domain\ValueObject\SpecificData;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsData;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class PayMethodTest extends TestCase
{
    public function testJsonSerializeWithCoreFieldsOnly(): void
    {
        $payMethod = PayMethod::of(type: PayMethodType::Pbl, value: 'c');

        self::assertSame(['type' => 'PBL', 'value' => 'c'], $payMethod->jsonSerialize());
    }

    public function testJsonSerializeOmitsValueWhenNotProvided(): void
    {
        $payMethod = PayMethod::of(type: PayMethodType::PaymentWall);

        self::assertSame(['type' => 'PAYMENT_WALL'], $payMethod->jsonSerialize());
    }

    public function testJsonSerializeSerializesEnumsAsPayUValues(): void
    {
        $payMethod = PayMethod::of(
            type: PayMethodType::CardToken,
            value: 'TOKEN123',
            authorizationType: AuthorizationType::PreAuthorization,
        );

        self::assertSame(
            [
                'type' => 'CARD_TOKEN',
                'value' => 'TOKEN123',
                'authorizationType' => 'PRE_AUTHORIZATION',
            ],
            $payMethod->jsonSerialize()
        );
    }

    public function testJsonSerializeSerializesNestedValueObjects(): void
    {
        $payMethod = PayMethod::of(
            type: PayMethodType::Pbl,
            value: 'c',
            cardInstallments: new CardInstallments(provider: 'mbk', number: '5'),
            specificData: [new SpecificData(name: 'invoice', value: 'FV-1')],
        );

        self::assertSame(
            [
                'type' => 'PBL',
                'value' => 'c',
                'specificData' => [['name' => 'invoice', 'value' => 'FV-1']],
                'cardInstallments' => ['provider' => 'mbk', 'number' => '5'],
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testJsonSerializeOmitsEmptySpecificData(): void
    {
        $payMethod = PayMethod::of(type: PayMethodType::Pbl, value: 'c');

        self::assertSame(['type' => 'PBL', 'value' => 'c'], $payMethod->jsonSerialize());
    }

    public function testClickToPayVisaNamedConstructorWrapsPayloadUnderVisaKey(): void
    {
        $payMethod = PayMethod::clickToPayVisa(new ClickToPayVisa('corr-1'));

        self::assertSame(
            [
                'type' => 'PBL',
                'value' => 'c',
                'clickToPay' => ['visa' => ['srcCorrelationId' => 'corr-1']],
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testClickToPayMastercardNamedConstructorWrapsPayloadUnderMastercardKey(): void
    {
        $payMethod = PayMethod::clickToPayMastercard(new ClickToPayMastercard('corr-1'));

        self::assertSame(
            [
                'type' => 'PBL',
                'value' => 'c',
                'clickToPay' => ['mastercard' => ['srcCorrelationId' => 'corr-1']],
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testDigitalWalletNamedConstructorGroupsWalletPayload(): void
    {
        $payMethod = PayMethod::digitalWallet(
            card: new Card(number: '5100052384536818', expirationMonth: '11', expirationYear: '2030'),
            threeDsData: new ThreeDsData(tavv: 'AgAAAHsAodvkMRYBFT8CgOpQEAA='),
            sourcePaymentFlow: SourcePaymentFlow::VisaMobile,
        );

        self::assertSame(
            [
                'type' => 'PAYMENT_WALL',
                'card' => [
                    'number' => '5100052384536818',
                    'expirationMonth' => '11',
                    'expirationYear' => '2030',
                ],
                'threeDsData' => ['tavv' => 'AgAAAHsAodvkMRYBFT8CgOpQEAA='],
                'sourcePaymentFlow' => 'VISA_MOBILE',
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testDigitalWalletReproducesDocumentedPayURequest(): void
    {
        $payMethod = PayMethod::digitalWallet(
            card: new Card(number: '5100052384536818', expirationMonth: '11', expirationYear: '2030'),
            threeDsData: new ThreeDsData(tavv: 'AgAAAHsAodvkMRYBFT8CgOpQEAA='),
            sourcePaymentFlow: SourcePaymentFlow::VisaMobile,
        );

        self::assertSame(
            [
                'type' => 'PAYMENT_WALL',
                'card' => [
                    'number' => '5100052384536818',
                    'expirationMonth' => '11',
                    'expirationYear' => '2030',
                ],
                'threeDsData' => ['tavv' => 'AgAAAHsAodvkMRYBFT8CgOpQEAA='],
                'sourcePaymentFlow' => 'VISA_MOBILE',
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testBlikRedirectNamedConstructorSetsPblTypeAndBlikValue(): void
    {
        $payMethod = PayMethod::blikRedirect();

        self::assertSame(['type' => 'PBL', 'value' => 'blik'], $payMethod->jsonSerialize());
    }

    public function testBlikAuthorizationCodePutsCodeInValueNotAuthorizationCode(): void
    {
        $payMethod = PayMethod::blikAuthorizationCode(code: '777123');

        self::assertSame(['type' => 'BLIK_AUTHORIZATION_CODE', 'value' => '777123'], $payMethod->jsonSerialize());
    }

    public function testBlikAuthorizationCodeAttachesBlikData(): void
    {
        $payMethod = PayMethod::blikAuthorizationCode(
            code: '777123',
            blikData: new BlikData(appKey: 'app-key', countryCode: BlikCountryCode::Pl),
        );

        self::assertSame(
            [
                'type' => 'BLIK_AUTHORIZATION_CODE',
                'value' => '777123',
                'blikData' => ['appKey' => 'app-key', 'countryCode' => 'PL'],
            ],
            \json_decode(\json_encode($payMethod, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testBlikTokenPutsTokenInValue(): void
    {
        $payMethod = PayMethod::blikToken(token: 'TOKEN123');

        self::assertSame(['type' => 'BLIK_TOKEN', 'value' => 'TOKEN123'], $payMethod->jsonSerialize());
    }

    public function testEmptyValueThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PayMethod::of(type: PayMethodType::Pbl, value: '');
    }

    public function testEmptyAuthorizationCodeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PayMethod::of(type: PayMethodType::Pbl, value: 'c', authorizationCode: '');
    }

    public function testEmptyAmountThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PayMethod::of(type: PayMethodType::Pbl, value: 'c', amount: '');
    }

    public function testNonSpecificDataItemThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PayMethod::of(type: PayMethodType::Pbl, value: 'c', specificData: [['name' => 'invoice']]);
    }
}
