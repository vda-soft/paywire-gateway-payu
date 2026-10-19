<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\SdkEphemPubKey;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class SdkEphemPubKeyTest extends TestCase
{
    public function testJsonSerializeSerializesFields(): void
    {
        $sdkEphemPubKey = new SdkEphemPubKey(
            y: 'Y_VALUE',
            x: 'X_VALUE',
            kty: 'EC',
            crv: 'P-256'
        );

        self::assertSame(
            [
                'y' => 'Y_VALUE',
                'x' => 'X_VALUE',
                'kty' => 'EC',
                'crv' => 'P-256',
            ],
            $sdkEphemPubKey->jsonSerialize()
        );
    }

    public function testEmptyYThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SdkEphemPubKey(y: '', x: 'x', kty: 'kty', crv: 'crv');
    }

    public function testEmptyXThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SdkEphemPubKey(y: 'y', x: '', kty: 'kty', crv: 'crv');
    }

    public function testEmptyKtyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SdkEphemPubKey(y: 'y', x: 'x', kty: '', crv: 'crv');
    }

    public function testEmptyCrvThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new SdkEphemPubKey(y: 'y', x: 'x', kty: 'kty', crv: '');
    }
}
