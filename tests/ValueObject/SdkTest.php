<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Sdk;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\SdkEphemPubKey;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class SdkTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $sdk = new Sdk(
            sdkReferenceNumber: 'SDK_REF_123',
            sdkMaxTimeout: 300,
            sdkAppID: 'APP_ID_123',
            sdkEncData: 'ENC_DATA_123',
            sdkTransID: 'TRANS_ID_123',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );

        self::assertSame(
            [
                'sdkReferenceNumber' => 'SDK_REF_123',
                'sdkMaxTimeout' => '300',
                'sdkAppID' => 'APP_ID_123',
                'sdkEncData' => 'ENC_DATA_123',
                'sdkTransID' => 'TRANS_ID_123',
                'sdkEphemPubKey' => [
                    'y' => 'Y_VALUE',
                    'x' => 'X_VALUE',
                    'kty' => 'EC',
                    'crv' => 'P-256',
                ],
            ],
            $sdk->jsonSerialize()
        );
    }

    public function testEmptySdkReferenceNumberThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Sdk(
            sdkReferenceNumber: '',
            sdkMaxTimeout: 300,
            sdkAppID: 'APP_ID_123',
            sdkEncData: 'ENC_DATA_123',
            sdkTransID: 'TRANS_ID_123',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );
    }

    public function testNonPositiveSdkMaxTimeoutThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Sdk(
            sdkReferenceNumber: 'SDK_REF_123',
            sdkMaxTimeout: 0,
            sdkAppID: 'APP_ID_123',
            sdkEncData: 'ENC_DATA_123',
            sdkTransID: 'TRANS_ID_123',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );
    }

    public function testEmptySdkAppIDThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Sdk(
            sdkReferenceNumber: 'SDK_REF_123',
            sdkMaxTimeout: 300,
            sdkAppID: '',
            sdkEncData: 'ENC_DATA_123',
            sdkTransID: 'TRANS_ID_123',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );
    }

    public function testEmptySdkEncDataThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Sdk(
            sdkReferenceNumber: 'SDK_REF_123',
            sdkMaxTimeout: 300,
            sdkAppID: 'APP_ID_123',
            sdkEncData: '',
            sdkTransID: 'TRANS_ID_123',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );
    }

    public function testEmptySdkTransIDThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Sdk(
            sdkReferenceNumber: 'SDK_REF_123',
            sdkMaxTimeout: 300,
            sdkAppID: 'APP_ID_123',
            sdkEncData: 'ENC_DATA_123',
            sdkTransID: '',
            sdkEphemPubKey: new SdkEphemPubKey(
                y: 'Y_VALUE',
                x: 'X_VALUE',
                kty: 'EC',
                crv: 'P-256'
            )
        );
    }
}
