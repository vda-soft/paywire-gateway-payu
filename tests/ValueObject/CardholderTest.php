<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\AccountInformation;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\BillingAddress;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Cardholder;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class CardholderTest extends TestCase
{
    public function testJsonSerializeWithAllFields(): void
    {
        $cardholder = new Cardholder(
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
                cardAddedIndicator: '01'
            ),
            billingAddress: new BillingAddress(
                street: '123 Main St',
                postalCode: '12345',
                city: 'New York',
                state: 'NY',
                countryCode: 'US'
            )
        );

        $expected = [
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
        ];

        self::assertSame($expected, $cardholder->jsonSerialize());
    }

    public function testJsonSerializeWithOnlyName(): void
    {
        $cardholder = new Cardholder(name: 'John Doe');

        self::assertSame(
            [
                'name' => 'John Doe',
            ],
            $cardholder->jsonSerialize()
        );
    }

    public function testEmptyNameThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Cardholder(name: '');
    }
}
