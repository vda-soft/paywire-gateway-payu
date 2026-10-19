<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayVisa;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class ClickToPayVisaTest extends TestCase
{
    public function testJsonSerializeReturnsCorrelationId(): void
    {
        self::assertSame(
            ['srcCorrelationId' => 'corr-1'],
            (new ClickToPayVisa('corr-1'))->jsonSerialize()
        );
    }

    public function testEmptySrcCorrelationIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ClickToPayVisa('');
    }
}
