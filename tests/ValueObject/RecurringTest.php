<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Recurring;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class RecurringTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $recurring = new Recurring(
            frequency: '1',
            expiry: '20251231',
        );

        self::assertSame(
            [
                'frequency' => '1',
                'expiry' => '20251231',
            ],
            $recurring->jsonSerialize()
        );
    }

    public function testEmptyFrequencyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Recurring(
            frequency: '',
            expiry: '20251231',
        );
    }

    public function testEmptyExpiryThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Recurring(
            frequency: '1',
            expiry: '',
        );
    }
}
