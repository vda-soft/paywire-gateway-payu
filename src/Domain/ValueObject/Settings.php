<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject;

use PayWire\Gateway\PayU\Domain\OrderCreateRequestExtension;
use Webmozart\Assert\Assert;

final readonly class Settings implements OrderCreateRequestExtension
{
    /**
     * @param array<string, list<int>>|null $cardInstallmentsOptions
     * @param list<string>|null $enrichNotificationWith
     */
    public function __construct(
        public ?array $cardInstallmentsOptions = null,
        public ?bool $syncProcessing = null,
        public ?array $enrichNotificationWith = null,
    ) {
        foreach ($this->cardInstallmentsOptions ?? [] as $provider => $installments) {
            Assert::regex($provider, '/^[a-z0-9_]+$/', "Invalid provider key: $provider");
            Assert::allInteger($installments, "Installments for $provider must be integers");
            Assert::allGreaterThan($installments, 0, "Installments for $provider must be positive");
        }
        if (null !== $this->enrichNotificationWith) {
            Assert::allString($this->enrichNotificationWith);
        }
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = \array_filter(
            [
                'cardInstallmentsOptions' => $this->cardInstallmentsOptions,
                'syncProcessing' => $this->syncProcessing,
                'enrichNotificationWith' => $this->enrichNotificationWith,
            ],
            static fn(mixed $v): bool => null !== $v
        );

        return [] === $data ? [] : ['settings' => $data];
    }
}
