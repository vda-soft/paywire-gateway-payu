<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\BillingAddress;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class BillingAddressTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $billingAddress = new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: 'NY',
            countryCode: 'US',
        );

        self::assertSame(
            [
                'street' => '123 Main St',
                'postalCode' => '12345',
                'city' => 'New York',
                'state' => 'NY',
                'countryCode' => 'US',
            ],
            $billingAddress->jsonSerialize()
        );
    }

    public function testEmptyStreetThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '',
            postalCode: '12345',
            city: 'New York',
            state: 'NY',
            countryCode: 'US',
        );
    }

    public function testEmptyPostalCodeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '',
            city: 'New York',
            state: 'NY',
            countryCode: 'US',
        );
    }

    public function testEmptyCityThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: '',
            state: 'NY',
            countryCode: 'US',
        );
    }

    public function testEmptyStateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: '',
            countryCode: 'US',
        );
    }

    public function testEmptyCountryCodeThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: 'NY',
            countryCode: '',
        );
    }

    public function testTooLongCityThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: \str_repeat('a', 51),
            state: 'NY',
            countryCode: 'US',
        );
    }

    public function testInvalidStateLengthThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: 'NEWYORK', // Should be 2 chars
            countryCode: 'US',
        );
    }

    public function testInvalidCountryCodeLengthThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: 'NY',
            countryCode: 'USA', // Should be 2 chars
        );
    }

    public function testInvalidCountryCodeLowercaseThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BillingAddress(
            street: '123 Main St',
            postalCode: '12345',
            city: 'New York',
            state: 'NY',
            countryCode: 'us', // Should be uppercase
        );
    }
}
