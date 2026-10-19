<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class AccountInformation implements \JsonSerializable
{
    public function __construct(
        public ?string $createDate = null,
        public ?bool $suspiciousActivity = null,
        public ?string $deliveryAddressFirstUsedDate = null,
        public ?string $deliveryAddressUsageIndicator = null,
        public ?int $pastOrdersYear = null,
        public ?int $pastOrdersDay = null,
        public ?int $purchasesLastSixMonths = null,
        public ?string $changeDate = null,
        public ?bool $passwordChanged = null,
        public ?string $passwordChangeIndicator = null,
        public ?string $nameToRecipientMatch = null,
        public ?int $addCardAttemptsDay = null,
        public ?string $authMethod = null,
        public ?string $authDateTime = null,
        public ?string $cardAddedDate = null,
        public ?string $cardAddedIndicator = null,
    ) {
        Assert::nullOrStringNotEmpty($this->createDate);
        Assert::nullOrStringNotEmpty($this->deliveryAddressFirstUsedDate);
        Assert::nullOrStringNotEmpty($this->deliveryAddressUsageIndicator);
        Assert::nullOrStringNotEmpty($this->changeDate);
        Assert::nullOrStringNotEmpty($this->passwordChangeIndicator);
        Assert::nullOrStringNotEmpty($this->nameToRecipientMatch);
        Assert::nullOrStringNotEmpty($this->authMethod);
        Assert::nullOrStringNotEmpty($this->authDateTime);
        Assert::nullOrStringNotEmpty($this->cardAddedDate);
        Assert::nullOrStringNotEmpty($this->cardAddedIndicator);

        if (null !== $this->pastOrdersYear) {
            Assert::integer($this->pastOrdersYear);
            Assert::greaterThan($this->pastOrdersYear, 0);
        }

        if (null !== $this->pastOrdersDay) {
            Assert::integer($this->pastOrdersDay);
            Assert::greaterThan($this->pastOrdersDay, 0);
            Assert::range($this->pastOrdersDay, 1, 31, ':pastOrdersDay must be between 1 and 31');
        }

        if (null !== $this->purchasesLastSixMonths) {
            Assert::integer($this->purchasesLastSixMonths);
            Assert::greaterThan($this->purchasesLastSixMonths, 0);
        }

        if (null !== $this->addCardAttemptsDay) {
            Assert::integer($this->addCardAttemptsDay);
            Assert::greaterThan($this->addCardAttemptsDay, 0);
            Assert::range($this->addCardAttemptsDay, 1, 31, ':addCardAttemptsDay must be between 1 and 31');
        }
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return \array_filter(
            [
                'createDate' => $this->createDate,
                'suspiciousActivity' => $this->suspiciousActivity,
                'deliveryAddressFirstUsedDate' => $this->deliveryAddressFirstUsedDate,
                'deliveryAddressUsageIndicator' => $this->deliveryAddressUsageIndicator,
                'pastOrdersYear' => $this->pastOrdersYear,
                'pastOrdersDay' => $this->pastOrdersDay,
                'purchasesLastSixMonths' => $this->purchasesLastSixMonths,
                'changeDate' => $this->changeDate,
                'passwordChanged' => $this->passwordChanged,
                'passwordChangeIndicator' => $this->passwordChangeIndicator,
                'nameToRecipientMatch' => $this->nameToRecipientMatch,
                'addCardAttemptsDay' => $this->addCardAttemptsDay,
                'authMethod' => $this->authMethod,
                'authDateTime' => $this->authDateTime,
                'cardAddedDate' => $this->cardAddedDate,
                'cardAddedIndicator' => $this->cardAddedIndicator,
            ],
            static fn(mixed $value): bool => null !== $value
        );
    }
}
