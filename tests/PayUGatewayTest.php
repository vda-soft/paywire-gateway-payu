<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU\Tests;

use PayWire\Gateway\PayU\Domain\Configuration;
use PayWire\Gateway\PayU\PayUGateway;
use PHPUnit\Framework\TestCase;

final class PayUGatewayTest extends TestCase
{
    public function testGatewayCanBeInstantiated(): void
    {
        $config = new Configuration(
            posId: '123456',
            clientId: 'client_id',
            clientSecret: 'client_secret',
            notifyUrl: 'https://example.com/notify',
            continueUrl: 'https://example.com/continue',
            sandbox: true,
        );

        self::assertInstanceOf(PayUGateway::class, new PayUGateway($config));
    }
}
