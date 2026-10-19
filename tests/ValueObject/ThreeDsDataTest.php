<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests\ValueObject;

use PayWire\Gateway\PayU\Domain\Enum\ThreeDsStatus;
use PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs\ThreeDsData;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

final class ThreeDsDataTest extends TestCase
{
    public function testJsonSerializeWithStatusAndTransactionId(): void
    {
        $threeDsData = new ThreeDsData(
            status3Ds: ThreeDsStatus::Successful,
            dsTransactionId: 'tx-1',
        );

        self::assertSame(
            ['status3Ds' => 'Y', 'dsTransactionId' => 'tx-1'],
            $threeDsData->jsonSerialize()
        );
    }

    public function testJsonSerializeWithAllFields(): void
    {
        $threeDsData = new ThreeDsData(
            status3Ds: ThreeDsStatus::Attempt,
            dsTransactionId: 'tx-1',
            status3DsDescription: 'Attempted',
            xid: 'xid-1',
            eciCode: '06',
            cavv: 'cavv-1',
            tavv: 'tavv-1',
        );

        self::assertSame(
            [
                'status3Ds' => 'A',
                'dsTransactionId' => 'tx-1',
                'status3DsDescription' => 'Attempted',
                'xid' => 'xid-1',
                'eciCode' => '06',
                'cavv' => 'cavv-1',
                'tavv' => 'tavv-1',
            ],
            $threeDsData->jsonSerialize()
        );
    }

    public function testJsonSerializeWithTavvOnly(): void
    {
        $threeDsData = new ThreeDsData(tavv: 'AgAAAHsAodvkMRYBFT8CgOpQEAA=');

        self::assertSame(
            ['tavv' => 'AgAAAHsAodvkMRYBFT8CgOpQEAA='],
            $threeDsData->jsonSerialize()
        );
    }

    public function testEmptyDsTransactionIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ThreeDsData(status3Ds: ThreeDsStatus::Successful, dsTransactionId: '');
    }

    public function testTooLongStatus3DsDescriptionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ThreeDsData(
            status3Ds: ThreeDsStatus::Successful,
            dsTransactionId: 'tx-1',
            status3DsDescription: \str_repeat('a', 1025),
        );
    }
}
