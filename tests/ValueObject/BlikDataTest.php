<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\Enum\BlikCountryCode;
use PayWire\Gateway\PayU\Domain\Enum\RecommendedAuthLevel;
use PayWire\Gateway\PayU\Domain\ValueObject\BlikData;
use PayWire\Gateway\PayU\Domain\ValueObject\BlikRecurring;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class BlikDataTest extends TestCase
{
    public function testJsonSerializeOmitsNullFields(): void
    {
        self::assertSame([], (new BlikData())->jsonSerialize());
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $blikData = new BlikData(
            aliasLabelProposal: 'alias-1',
            registerTokenValue: 'token-1',
            register: false,
            appKey: 'app-key',
            recommendedAuthLevel: RecommendedAuthLevel::RequiredConfirmation,
            countryCode: BlikCountryCode::Pl,
            recurring: new BlikRecurring(),
        );

        self::assertSame(
            [
                'aliasLabelProposal' => 'alias-1',
                'registerTokenValue' => 'token-1',
                'register' => false,
                'appKey' => 'app-key',
                'recommendedAuthLevel' => 'REQUIRED_CONFIRMATION',
                'countryCode' => 'PL',
                'recurring' => ['type' => 'O'],
            ],
            \json_decode(\json_encode($blikData, JSON_THROW_ON_ERROR), true)
        );
    }

    public function testEmptyAppKeyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BlikData(appKey: '');
    }
}
