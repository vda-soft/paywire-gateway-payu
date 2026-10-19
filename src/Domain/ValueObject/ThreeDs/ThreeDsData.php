<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use PayWire\Gateway\PayU\Domain\Enum\ThreeDsStatus;
use Webmozart\Assert\Assert;

final readonly class ThreeDsData implements \JsonSerializable
{
    public function __construct(
        public ?ThreeDsStatus $status3Ds = null,
        public ?string $dsTransactionId = null,
        public ?string $status3DsDescription = null,
        public ?string $xid = null,
        public ?string $eciCode = null,
        public ?string $cavv = null,
        public ?string $tavv = null,
    ) {
        Assert::nullOrStringNotEmpty($this->dsTransactionId);
        Assert::nullOrMaxLength($this->dsTransactionId, 36);
        Assert::nullOrMaxLength($this->status3DsDescription, 1024);
        Assert::nullOrMaxLength($this->xid, 40);
        Assert::nullOrStringNotEmpty($this->eciCode);
        Assert::nullOrMaxLength($this->cavv, 200);
        Assert::nullOrMaxLength($this->tavv, 200);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'status3Ds' => $this->status3Ds?->value,
                'dsTransactionId' => $this->dsTransactionId,
                'status3DsDescription' => $this->status3DsDescription,
                'xid' => $this->xid,
                'eciCode' => $this->eciCode,
                'cavv' => $this->cavv,
                'tavv' => $this->tavv,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
