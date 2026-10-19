<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final readonly class MerchantRiskIndicator implements \JsonSerializable
{
    public function __construct(
        public string $orderType,
        public string $shipIndicator,
        public bool $preOrdered = false,
        public ?string $preOrderedDate = null,
        public ?string $deliveryTimeFrame = null,
        public bool $reordered = false,
        public ?MerchantFunds $merchantFunds = null,
    ) {
        Assert::stringNotEmpty($this->orderType);
        Assert::stringNotEmpty($this->shipIndicator);
        Assert::nullOrStringNotEmpty($this->preOrderedDate);
        Assert::nullOrStringNotEmpty($this->deliveryTimeFrame);

        if ($this->preOrdered && null === $this->preOrderedDate) {
            throw new InvalidArgumentException('preOrderedDate is required when preOrdered is true');
        }
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'orderType' => $this->orderType,
                'shipIndicator' => $this->shipIndicator,
                'preOrdered' => $this->preOrdered,
                'preOrderedDate' => $this->preOrderedDate,
                'deliveryTimeFrame' => $this->deliveryTimeFrame,
                'reordered' => $this->reordered,
                'merchantFunds' => $this->merchantFunds?->jsonSerialize(),
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
