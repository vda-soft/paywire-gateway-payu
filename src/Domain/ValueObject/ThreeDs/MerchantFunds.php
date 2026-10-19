<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class MerchantFunds implements \JsonSerializable
{
    public function __construct(
        public string $amount,
        public string $currencyCode,
    ) {
        Assert::stringNotEmpty($this->amount);
        Assert::stringNotEmpty($this->currencyCode);
        Assert::regex($this->currencyCode, '/^[A-Z]{3}$/');
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'currencyCode' => $this->currencyCode,
        ];
    }
}
