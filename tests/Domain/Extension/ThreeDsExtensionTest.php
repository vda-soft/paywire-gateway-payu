<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\Domain\Extension;

use PayWire\Gateway\PayU\Domain\Enum\ChallengeRequested;
use PayWire\Gateway\PayU\Domain\Extension\ThreeDsExtension;
use PayWire\Gateway\PayU\Domain\OrderCreateRequestExtension;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Browser;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\RiskData;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsAuthentication;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class ThreeDsExtensionTest extends TestCase
{
    public function testImplementsOrderCreateRequestExtension(): void
    {
        $extension = new ThreeDsExtension();

        self::assertInstanceOf(OrderCreateRequestExtension::class, $extension);
    }

    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new ThreeDsExtension())->jsonSerialize());
    }

    public function testJsonSerializeWithDeviceFingerprintOnly(): void
    {
        $extension = new ThreeDsExtension(deviceFingerprint: 'fp-abc123');

        self::assertSame(['deviceFingerprint' => 'fp-abc123'], $extension->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $extension = new ThreeDsExtension(
            threeDsAuthentication: new ThreeDsAuthentication(
                challengeRequested: ChallengeRequested::Yes,
            ),
            riskData: new RiskData(browser: $this->browser()),
            deviceFingerprint: 'fp-abc123',
        );

        self::assertSame(
            [
                'threeDsAuthentication' => ['challengeRequested' => 'YES'],
                'riskData' => [
                    'browser' => [
                        'acceptHeaders' => 'text/html',
                        'requestIP' => '147.135.116.156',
                        'screenWidth' => '1920',
                        'javaEnabled' => true,
                        'timezoneOffset' => '-120',
                        'screenHeight' => '1080',
                        'userAgent' => 'Mozilla/5.0',
                        'colorDepth' => '24',
                        'language' => 'pl-PL',
                    ],
                ],
                'deviceFingerprint' => 'fp-abc123',
            ],
            $extension->jsonSerialize()
        );
    }

    public function testTooLongDeviceFingerprintThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ThreeDsExtension(deviceFingerprint: \str_repeat('a', 256));
    }

    private function browser(): Browser
    {
        return new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL',
        );
    }
}
