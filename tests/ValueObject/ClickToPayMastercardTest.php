<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ClickToPayMastercard;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class ClickToPayMastercardTest extends TestCase
{
    public function testJsonSerializeReturnsCorrelationIds(): void
    {
        self::assertSame(
            ['srcCorrelationId' => 'corr-2', 'srcDigitalCardId' => 'card-9'],
            (new ClickToPayMastercard('corr-2', 'card-9'))->jsonSerialize()
        );
    }

    public function testEmptySrcDigitalCardIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ClickToPayMastercard('corr-2', '');
    }
}
