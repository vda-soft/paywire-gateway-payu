<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class Sdk implements \JsonSerializable
{
    public function __construct(
        public string $sdkReferenceNumber,
        public int $sdkMaxTimeout,
        public string $sdkAppID,
        public string $sdkEncData,
        public string $sdkTransID,
        public SdkEphemPubKey $sdkEphemPubKey,
    ) {
        Assert::stringNotEmpty($this->sdkReferenceNumber);
        Assert::greaterThan($this->sdkMaxTimeout, 0);
        Assert::stringNotEmpty($this->sdkAppID);
        Assert::stringNotEmpty($this->sdkEncData);
        Assert::stringNotEmpty($this->sdkTransID);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'sdkReferenceNumber' => $this->sdkReferenceNumber,
            'sdkMaxTimeout' => (string) $this->sdkMaxTimeout,
            'sdkAppID' => $this->sdkAppID,
            'sdkEncData' => $this->sdkEncData,
            'sdkTransID' => $this->sdkTransID,
            'sdkEphemPubKey' => $this->sdkEphemPubKey->jsonSerialize(),
        ];
    }
}
