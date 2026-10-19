<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\MerchantFunds;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\MerchantRiskIndicator;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class MerchantRiskIndicatorTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $merchantRiskIndicator = new MerchantRiskIndicator(
            orderType: '01',
            shipIndicator: '01',
            preOrdered: true,
            preOrderedDate: '202301011200',
            deliveryTimeFrame: '01',
            reordered: false,
            merchantFunds: new MerchantFunds(
                amount: '100.00',
                currencyCode: 'USD'
            )
        );

        self::assertSame(
            [
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
            $merchantRiskIndicator->jsonSerialize()
        );
    }

    public function testJsonSerializeWithOptionalFieldsNull(): void
    {
        $merchantRiskIndicator = new MerchantRiskIndicator(
            orderType: '01',
            shipIndicator: '01',
        );

        self::assertSame(
            [
                'orderType' => '01',
                'shipIndicator' => '01',
                'preOrdered' => false,
                'reordered' => false,
            ],
            $merchantRiskIndicator->jsonSerialize()
        );
    }

    public function testEmptyOrderTypeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantRiskIndicator(
            orderType: '',
            shipIndicator: '01',
        );
    }

    public function testEmptyShipIndicatorThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantRiskIndicator(
            orderType: '01',
            shipIndicator: '',
        );
    }

    public function testPreOrderedRequiresPreOrderedDate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MerchantRiskIndicator(
            orderType: '01',
            shipIndicator: '01',
            preOrdered: true,
            preOrderedDate: null,
        );
    }
}
