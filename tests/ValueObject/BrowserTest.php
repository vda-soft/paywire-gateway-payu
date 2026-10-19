<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Browser;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class BrowserTest extends TestCase
{
    public function testJsonSerializeSerializesAllFields(): void
    {
        $browser = new Browser(
            acceptHeaders: 'text/html,application/xhtml+xml',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL',
        );

        self::assertSame(
            [
                'acceptHeaders' => 'text/html,application/xhtml+xml',
                'requestIP' => '147.135.116.156',
                'screenWidth' => '1920',
                'javaEnabled' => true,
                'timezoneOffset' => '-120',
                'screenHeight' => '1080',
                'userAgent' => 'Mozilla/5.0',
                'colorDepth' => '24',
                'language' => 'pl-PL',
            ],
            $browser->jsonSerialize()
        );
    }

    public function testEmptyAcceptHeadersThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: '',
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

    public function testEmptyUserAgentThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: '',
            colorDepth: 24,
            language: 'pl-PL',
        );
    }

    public function testTooLongLanguageThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL-EXTENDED',
        );
    }

    public function testInvalidScreenWidthThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 0,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL',
        );
    }

    public function testInvalidScreenHeightThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 0,
            userAgent: 'Mozilla/5.0',
            colorDepth: 24,
            language: 'pl-PL',
        );
    }

    public function testInvalidColorDepthThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 0,
            language: 'pl-PL',
        );
    }

    public function testColorDepthTooHighThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Browser(
            acceptHeaders: 'text/html',
            requestIP: '147.135.116.156',
            screenWidth: 1920,
            javaEnabled: true,
            timezoneOffset: -120,
            screenHeight: 1080,
            userAgent: 'Mozilla/5.0',
            colorDepth: 49,
            language: 'pl-PL',
        );
    }
}
