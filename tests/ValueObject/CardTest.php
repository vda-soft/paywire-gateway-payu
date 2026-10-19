<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\Card;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class CardTest extends TestCase
{
    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new Card())->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $card = new Card(
            number: '4111111111111111',
            expirationMonth: '12',
            expirationYear: '2030',
            cvv: '123',
            firstTransactionId: 'tx-1',
        );

        self::assertSame(
            [
                'number' => '4111111111111111',
                'expirationMonth' => '12',
                'expirationYear' => '2030',
                'cvv' => '123',
                'firstTransactionId' => 'tx-1',
            ],
            $card->jsonSerialize()
        );
    }

    public function testEmptyNumberThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Card(number: '');
    }
}
