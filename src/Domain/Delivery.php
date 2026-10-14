<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class Delivery implements \JsonSerializable
{
    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public string $countryCode,
        public ?string $name = null,
        public ?string $postalBox = null,
        public ?string $state = null,
        public ?string $recipientName = null,
        public ?string $recipientEmail = null,
        public ?string $recipientPhone = null,
    ) {
        Assert::notEmpty($street, 'Street cannot be empty');
        Assert::notEmpty($postalCode, 'Postal code cannot be empty');
        Assert::notEmpty($city, 'City cannot be empty');
        Assert::regex($countryCode, '/^[A-Z]{2}$/', 'Country code must be ISO 3166-1 alpha-2');
        Assert::nullOrRegex($this->state, '/^[A-Z0-9]{1,3}$/', 'State must be alphanumeric (max 3 chars)');
        Assert::nullOrEmail($this->recipientEmail, 'Recipient email must be valid');
        Assert::nullOrRegex($this->recipientPhone, '/^\+?[1-9]\d{1,14}$/', 'Recipient phone must be in E.164 format');
    }

    /** @return array<int|string, mixed> */
    public function jsonSerialize(): array
    {
        $data = [
            'street' => $this->street,
            'postalCode' => $this->postalCode,
            'city' => $this->city,
            'countryCode' => $this->countryCode,
            'name' => $this->name,
            'postalBox' => $this->postalBox,
            'state' => $this->state,
            'recipientName' => $this->recipientName,
            'recipientEmail' => $this->recipientEmail,
            'recipientPhone' => $this->recipientPhone,
        ];

        return \array_filter($data, static fn (mixed $v): bool => null !== $v);
    }
}
