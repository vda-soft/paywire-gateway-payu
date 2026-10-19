<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Domain\ValueObject\ThreeDs;

use Webmozart\Assert\Assert;

final readonly class Browser implements \JsonSerializable
{
    public function __construct(
        public string $acceptHeaders,
        public string $requestIP,
        public int $screenWidth,
        public bool $javaEnabled,
        public int $timezoneOffset,
        public int $screenHeight,
        public string $userAgent,
        public int $colorDepth,
        public string $language,
    ) {
        Assert::stringNotEmpty($this->acceptHeaders);
        Assert::stringNotEmpty($this->requestIP);
        Assert::greaterThan($this->screenWidth, 0);
        Assert::greaterThan($this->screenHeight, 0);
        Assert::range($this->colorDepth, 1, 48, ':colorDepth must be between 1 and 48');
        Assert::stringNotEmpty($this->userAgent);
        Assert::stringNotEmpty($this->language);
        Assert::maxLength($this->language, 8);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'acceptHeaders' => $this->acceptHeaders,
            'requestIP' => $this->requestIP,
            'screenWidth' => (string) $this->screenWidth,
            'javaEnabled' => $this->javaEnabled,
            'timezoneOffset' => (string) $this->timezoneOffset,
            'screenHeight' => (string) $this->screenHeight,
            'userAgent' => $this->userAgent,
            'colorDepth' => (string) $this->colorDepth,
            'language' => $this->language,
        ];
    }
}
