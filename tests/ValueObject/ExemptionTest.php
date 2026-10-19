<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\Enum\ExemptionValue;
use PayWire\Gateway\PayU\Domain\Enum\RejectionHandling;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\Exemption;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class ExemptionTest extends TestCase
{
    public function testJsonSerializeSerializesEnumValues(): void
    {
        $exemption = new Exemption(
            value: ExemptionValue::LowValue,
            rejectionHandling: RejectionHandling::Decline,
        );

        self::assertSame(
            ['value' => 'LOW_VALUE', 'rejectionHandling' => 'DECLINE'],
            $exemption->jsonSerialize()
        );
    }

    public function testJsonSerializeIncludesRiskScoreWhenProvided(): void
    {
        $exemption = new Exemption(
            value: ExemptionValue::LowRisk,
            rejectionHandling: RejectionHandling::PerformAuthentication,
            riskScore: '0.12',
        );

        self::assertSame(
            [
                'value' => 'LOW_RISK',
                'rejectionHandling' => 'PERFORM_AUTHENTICATION',
                'riskScore' => '0.12',
            ],
            $exemption->jsonSerialize()
        );
    }

    public function testTooLongRiskScoreThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Exemption(
            value: ExemptionValue::LowRisk,
            rejectionHandling: RejectionHandling::Decline,
            riskScore: \str_repeat('9', 129),
        );
    }
}
