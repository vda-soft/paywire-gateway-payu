<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Browser;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\RiskData;
use PHPUnit\Framework\TestCase;

final class RiskDataTest extends TestCase
{
    public function testJsonSerializeWrapsBrowser(): void
    {
        $riskData = new RiskData(browser: $this->browser());

        self::assertSame(
            [
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
            $riskData->jsonSerialize()
        );
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
