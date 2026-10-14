<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain;

use Webmozart\Assert\Assert;

final readonly class Configuration
{
    private const string API_URL = 'https://secure.payu.com';
    private const string API_URL_SANDBOX = 'https://secure.snd.payu.com';

    public function __construct(
        public string $posId,
        public string $clientId,
        public string $clientSecret,
        public ?string $notifyUrl = null,
        public ?string $continueUrl = null,
        public bool $sandbox = true,
    ) {
        Assert::notEmpty($posId, 'posId cannot be empty');
        Assert::notEmpty($clientId, 'clientId cannot be empty');
        Assert::notEmpty($clientSecret, 'clientSecret cannot be empty');
        Assert::nullOrRegex($notifyUrl, '/^https?:\/\/.+/', 'notifyUrl must be a valid URL');
        Assert::nullOrRegex($continueUrl, '/^https?:\/\/.+/', 'continueUrl must be a valid URL');
    }

    public function getBaseUrl(): string
    {
        return $this->sandbox
            ? self::API_URL_SANDBOX
            : self::API_URL;
    }

    public function getOAuthUrl(): string
    {
        return $this->getBaseUrl() . '/pl/standard/user/oauth/authorize';
    }

    public function getOrderCreateUrl(): string
    {
        return $this->getBaseUrl() . '/api/v2_1/orders';
    }
}
