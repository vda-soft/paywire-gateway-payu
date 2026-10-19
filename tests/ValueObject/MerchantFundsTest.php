<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\MerchantFunds;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class MerchantFundsTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $merchantFunds = new MerchantFunds(
            amount: '100.00',
            currencyCode: 'USD',
        );

        self::assertSame(
            [
                'amount' => '100.00',
                'currencyCode' => 'USD',
            ],
            $merchantFunds->jsonSerialize()
        );
    }

    public function testEmptyAmountThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantFunds(
            amount: '',
            currencyCode: 'USD',
        );
    }

    public function testEmptyCurrencyCodeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantFunds(
            amount: '100.00',
            currencyCode: '',
        );
    }

    public function testInvalidCurrencyCodeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantFunds(
            amount: '100.00',
            currencyCode: 'US', // Should be 3 letters
        );
    }

    public function testInvalidCurrencyCodeLowercaseThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantFunds(
            amount: '100.00',
            currencyCode: 'usd', // Should be uppercase
        );
    }
}
