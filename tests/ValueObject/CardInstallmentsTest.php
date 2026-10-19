<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\CardInstallments;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class CardInstallmentsTest extends TestCase
{
    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new CardInstallments())->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $installments = new CardInstallments(provider: 'mbk', number: '5');

        self::assertSame(['provider' => 'mbk', 'number' => '5'], $installments->jsonSerialize());
    }

    public function testEmptyProviderThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CardInstallments(provider: '');
    }
}
