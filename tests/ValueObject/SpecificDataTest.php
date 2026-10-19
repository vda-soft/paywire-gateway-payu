<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\SpecificData;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class SpecificDataTest extends TestCase
{
    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new SpecificData())->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $specificData = new SpecificData(name: 'invoice', value: 'FV-1');

        self::assertSame(['name' => 'invoice', 'value' => 'FV-1'], $specificData->jsonSerialize());
    }

    public function testEmptyNameThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SpecificData(name: '');
    }
}
