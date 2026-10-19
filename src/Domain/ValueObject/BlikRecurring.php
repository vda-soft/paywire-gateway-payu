<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class BlikRecurring implements \JsonSerializable
{
    private const string RECURRING_TYPE = 'O';

    public function __construct(
        public ?string $initializationDate = null,
        public ?string $expirationDate = null,
        public ?bool $authorizeDespiteRecurringNotSupported = null,
    ) {
        Assert::nullOrStringNotEmpty($this->initializationDate);
        Assert::nullOrStringNotEmpty($this->expirationDate);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'type' => self::RECURRING_TYPE,
                'initializationDate' => $this->initializationDate,
                'expirationDate' => $this->expirationDate,
                'authorizeDespiteRecurringNotSupported' => $this->authorizeDespiteRecurringNotSupported,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
