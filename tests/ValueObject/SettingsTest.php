<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\OrderCreateRequestExtension;
use PayWire\Gateway\PayU\Domain\ValueObject\Settings;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class SettingsTest extends TestCase
{
    public function testImplementsOrderCreateRequestExtension(): void
    {
        $settings = new Settings();

        self::assertInstanceOf(OrderCreateRequestExtension::class, $settings);
        self::assertSame('settings', $settings->key());
    }

    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new Settings())->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $settings = new Settings(
            cardInstallmentsOptions: ['mbk' => [1, 5, 12]],
            syncProcessing: true,
            enrichNotificationWith: ['invoice'],
        );

        self::assertSame(
            [
                'cardInstallmentsOptions' => ['mbk' => [1, 5, 12]],
                'syncProcessing' => true,
                'enrichNotificationWith' => ['invoice'],
            ],
            $settings->jsonSerialize()
        );
    }

    public function testInvalidProviderKeyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Invalid provider key: MBK');

        new Settings(cardInstallmentsOptions: ['MBK' => [1]]);
    }

    public function testNonIntegerInstallmentsThrow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Installments for mbk must be integers');

        new Settings(cardInstallmentsOptions: ['mbk' => [1, 'five']]);
    }

    public function testNonPositiveInstallmentsThrow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Installments for mbk must be positive');

        new Settings(cardInstallmentsOptions: ['mbk' => [0]]);
    }

    public function testNonStringEnrichNotificationWithThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Settings(enrichNotificationWith: ['invoice', 42]);
    }
}
