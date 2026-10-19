<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\AccountInformation;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class AccountInformationTest extends TestCase
{
    public function testJsonSerializeWithAllFields(): void
    {
        $accountInformation = new AccountInformation(
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
        );

        $expected = [
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
        ];

        self::assertSame($expected, $accountInformation->jsonSerialize());
    }

    public function testJsonSerializeWithAllNullFields(): void
    {
        $accountInformation = new AccountInformation();

        self::assertSame([], $accountInformation->jsonSerialize());
    }

    public function testInvalidPastOrdersYearThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            pastOrdersYear: 0, // Must be positive
        );
    }

    public function testInvalidPastOrdersDayThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            pastOrdersDay: 0, // Must be positive
        );
    }

    public function testPastOrdersDayTooHighThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            pastOrdersDay: 32, // Max 31
        );
    }

    public function testInvalidPurchasesLastSixMonthsThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            purchasesLastSixMonths: 0, // Must be positive
        );
    }

    public function testInvalidAddCardAttemptsDayThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            addCardAttemptsDay: 0, // Must be positive
        );
    }

    public function testAddCardAttemptsDayTooHighThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AccountInformation(
            addCardAttemptsDay: 32, // Max 31
        );
    }
}
