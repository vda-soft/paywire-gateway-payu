<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\BlikRecurring;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class BlikRecurringTest extends TestCase
{
    public function testJsonSerializeAlwaysIncludesRecurringType(): void
    {
        self::assertSame(['type' => 'O'], (new BlikRecurring())->jsonSerialize());
    }

    public function testJsonSerializeWithOptionalFields(): void
    {
        $recurring = new BlikRecurring(
            initializationDate: '2026-01-01T00:00:00+01:00',
            expirationDate: '2027-01-01T00:00:00+01:00',
            authorizeDespiteRecurringNotSupported: false,
        );

        self::assertSame(
            [
                'type' => 'O',
                'initializationDate' => '2026-01-01T00:00:00+01:00',
                'expirationDate' => '2027-01-01T00:00:00+01:00',
                'authorizeDespiteRecurringNotSupported' => false,
            ],
            $recurring->jsonSerialize()
        );
    }

    public function testEmptyInitializationDateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BlikRecurring(initializationDate: '');
    }
}
