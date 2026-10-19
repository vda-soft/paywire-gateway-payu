<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use PayWire\Gateway\PayU\Domain\Enum\BlikCountryCode;
use PayWire\Gateway\PayU\Domain\Enum\RecommendedAuthLevel;
use Webmozart\Assert\Assert;

final readonly class BlikData implements \JsonSerializable
{
    public function __construct(
        public ?string $aliasLabelProposal = null,
        public ?string $registerTokenValue = null,
        public ?bool $register = null,
        public ?string $appKey = null,
        public ?RecommendedAuthLevel $recommendedAuthLevel = null,
        public ?BlikCountryCode $countryCode = null,
        public ?BlikRecurring $recurring = null,
    ) {
        Assert::nullOrStringNotEmpty($this->aliasLabelProposal);
        Assert::nullOrStringNotEmpty($this->registerTokenValue);
        Assert::nullOrStringNotEmpty($this->appKey);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'aliasLabelProposal' => $this->aliasLabelProposal,
                'registerTokenValue' => $this->registerTokenValue,
                'register' => $this->register,
                'appKey' => $this->appKey,
                'recommendedAuthLevel' => $this->recommendedAuthLevel?->value,
                'countryCode' => $this->countryCode?->value,
                'recurring' => $this->recurring,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
