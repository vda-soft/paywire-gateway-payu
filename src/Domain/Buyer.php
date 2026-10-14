<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class Buyer implements \JsonSerializable
{
    public function __construct(
        public string $email,
        public string $language = 'pl',
        public ?string $extCustomerId = null,
        public ?string $phone = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $nin = null,
        public ?string $birthDate = null,
        public ?Delivery $delivery = null,
    ) {
        Assert::email($email, 'Buyer email must be valid');
        Assert::nullOrRegex($phone, '/^\+?[1-9]\d{1,14}$/', 'Phone must be in E.164 format');
        Assert::regex($language, '/^[a-z]{2}$/', 'Language must be ISO 639-1 code (2 letters)');
        Assert::nullOrRegex($birthDate, '/^\d{4}-\d{2}-\d{2}/', 'Birth date must be in ISO 8601 format');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'email' => $this->email,
            'language' => $this->language,
            'extCustomerId' => $this->extCustomerId,
            'phone' => $this->phone,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'nin' => $this->nin,
            'birthDate' => $this->birthDate,
            'delivery' => $this->delivery?->jsonSerialize(),
        ];

        return \array_filter($data, static fn (mixed $v): bool => null !== $v);
    }
}
