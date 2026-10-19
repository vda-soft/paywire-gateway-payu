<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\Enum\ChallengeRequested;
use PayWire\Gateway\PayU\Domain\Enum\ExemptionValue;
use PayWire\Gateway\PayU\Domain\Enum\RejectionHandling;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\AccountInformation;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\BillingAddress;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Browser;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Cardholder;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Exemption;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\MerchantFunds;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\MerchantRiskIndicator;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Recurring;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Sdk;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\SdkEphemPubKey;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsAuthentication;
use PHPUnit\Framework\TestCase;

final class ThreeDsAuthenticationTest extends TestCase
{
    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new ThreeDsAuthentication())->jsonSerialize());
    }

    public function testJsonSerializeSerializesNestedValueObjects(): void
    {
        $threeDsAuthentication = new ThreeDsAuthentication(
            challengeRequested: ChallengeRequested::Mandate,
            exemption: new Exemption(
                value: ExemptionValue::LowValue,
                rejectionHandling: RejectionHandling::Decline,
            ),
            browser: $this->browser(),
        );

        self::assertSame(
            [
                'challengeRequested' => 'MANDATE',
                'exemption' => ['value' => 'LOW_VALUE', 'rejectionHandling' => 'DECLINE'],
                'browser' => [
                    'acceptHeaders' => 'text/html',
                    'requestIP' => '147.135.116.156',
                    'screenWidth' => '1920',
                    'javaEnabled' => true,
                    'timezoneOffset' => '-120',
                    'screenHeight' => '1080',
                    'userAgent' => 'Mozilla/5.0',
                    'colorDepth' => '24',
                    'language' => 'pl-PL',
                ],
            ],
            $threeDsAuthentication->jsonSerialize()
        );
    }

    public function testJsonSerializeWithChallengeRequestedOnly(): void
    {
        $threeDsAuthentication = new ThreeDsAuthentication(
            challengeRequested: ChallengeRequested::No,
        );

        self::assertSame(['challengeRequested' => 'NO'], $threeDsAuthentication->jsonSerialize());
    }

    public function testJsonSerializeWithAllNewFields(): void
    {
        $threeDsAuthentication = new ThreeDsAuthentication(
            challengeRequested: ChallengeRequested::Mandate,
            exemption: new Exemption(
                value: ExemptionValue::LowValue,
                rejectionHandling: RejectionHandling::Decline,
            ),
            browser: $this->browser(),
            sdk: new Sdk(
                sdkReferenceNumber: 'SDK_REF_123',
                sdkMaxTimeout: 300,
                sdkAppID: 'APP_ID_123',
                sdkEncData: 'ENC_DATA_123',
                sdkTransID: 'TRANS_ID_123',
                sdkEphemPubKey: new SdkEphemPubKey(
                    y: 'Y_VALUE',
                    x: 'X_VALUE',
                    kty: 'EC',
                    crv: 'P-256'
                )
            ),
            merchantRiskIndicator: new MerchantRiskIndicator(
                orderType: '01',
                shipIndicator: '01',
                preOrdered: true,
                preOrderedDate: '202301011200',
                deliveryTimeFrame: '01',
                reordered: false,
                merchantFunds: new MerchantFunds(
                    '100.00',
                    'USD',
                ),
            ),
            recurring: new Recurring(
                frequency: '1',
                expiry: '20251231',
            ),
            cardholder: new Cardholder(
                name: 'John Doe',
                accountInformation: new AccountInformation(
                    createDate: '20200101120000Z',
                    suspiciousActivity: false,
                    deliveryAddressFirstUsedDate: '20200101120000Z',
                    deliveryAddressUsageIndicator: '01',
                    pastOrdersYear: 5,
                    pastOrdersDay: 10,
                    purchasesLastSixMonths: 15,
                    changeDate: '20230101120000Z',
                    passwordChanged: true,
                    passwordChangeIndicator: '01',
                    nameToRecipientMatch: 'YES',
                    addCardAttemptsDay: 1,
                    authMethod: '01',
                    authDateTime: '20230101120000Z',
                    cardAddedDate: '20200101120000Z',
                    cardAddedIndicator: '01',
                ),
                billingAddress: new BillingAddress(
                    street: '123 Main St',
                    postalCode: '12345',
                    city: 'New York',
                    state: 'NY',
                    countryCode: 'US',
                ),
            ),
        );

        $expected = [
            'challengeRequested' => 'MANDATE',
            'exemption' => ['value' => 'LOW_VALUE', 'rejectionHandling' => 'DECLINE'],
            'browser' => [
                'acceptHeaders' => 'text/html',
                'requestIP' => '147.135.116.156',
                'screenWidth' => '1920',
                'javaEnabled' => true,
                'timezoneOffset' => '-120',
                'screenHeight' => '1080',
                'userAgent' => 'Mozilla/5.0',
                'colorDepth' => '24',
                'language' => 'pl-PL',
            ],
            'sdk' => [
                'sdkReferenceNumber' => 'SDK_REF_123',
                'sdkMaxTimeout' => '300',
                'sdkAppID' => 'APP_ID_123',
                'sdkEncData' => 'ENC_DATA_123',
                'sdkTransID' => 'TRANS_ID_123',
                'sdkEphemPubKey' => [
                    'y' => 'Y_VALUE',
                    'x' => 'X_VALUE',
                    'kty' => 'EC',
                    'crv' => 'P-256',
                ],
            ],
            'merchantRiskIndicator' => [
                'orderType' => '01',
                'shipIndicator' => '01',
                'preOrdered' => true,
                'preOrderedDate' => '202301011200',
                'deliveryTimeFrame' => '01',
                'reordered' => false,
                'merchantFunds' => [
                    'amount' => '100.00',
                    'currencyCode' => 'USD',
                ],
            ],
            'recurring' => [
                'frequency' => '1',
                'expiry' => '20251231',
            ],
            'cardholder' => [
                'name' => 'John Doe',
                'accountInformation' => [
                    'createDate' => '20200101120000Z',
                    'suspiciousActivity' => false,
                    'deliveryAddressFirstUsedDate' => '20200101120000Z',
                    'deliveryAddressUsageIndicator' => '01',
                    'pastOrdersYear' => 5,
                    'pastOrdersDay' => 10,
                    'purchasesLastSixMonths' => 15,
                    'changeDate' => '20230101120000Z',
                    'passwordChanged' => true,
                    'passwordChangeIndicator' => '01',
                    'nameToRecipientMatch' => 'YES',
                    'addCardAttemptsDay' => 1,
                    'authMethod' => '01',
                    'authDateTime' => '20230101120000Z',
                    'cardAddedDate' => '20200101120000Z',
                    'cardAddedIndicator' => '01',
                ],
                'billingAddress' => [
                    'street' => '123 Main St',
                    'postalCode' => '12345',
                    'city' => 'New York',
                    'state' => 'NY',
                    'countryCode' => 'US',
                ],
            ],
        ];

        self::assertSame($expected, $threeDsAuthentication->jsonSerialize());
    }

    private function browser(): Browser
    {
        return new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL',
        );
    }
}
