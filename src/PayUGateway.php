<?php

declare(strict_types=1);

namespace PayWire\Gateway\PayU;

use PayWire\Core\Domain\Payment\Payment;
use PayWire\Core\Domain\Shared\Gateway;
use PayWire\Core\Domain\Shared\SubmissionResult;
use PayWire\Core\Domain\Shared\SubmitRequest as CoreSubmitRequest;
use PayWire\Gateway\PayU\Domain\Buyer;
use PayWire\Gateway\PayU\Domain\Configuration;
use PayWire\Gateway\PayU\Domain\OrderCreateRequest;
use PayWire\Gateway\PayU\Domain\Product;

final class PayUGateway implements Gateway
{
    public function __construct(
        private Configuration $configuration,
    ) {
    }

    public function prepareSubmitRequest(Payment $payment): OrderCreateRequest
    {
        $totalAmount = (int) $payment->total->getValueAtScale(2);

        return new OrderCreateRequest(
            customerIp: '127.0.0.1', // TODO: pass from request context
            merchantPosId: $payment->posId ?? $this->configuration->posId,
            description: $payment->description,
            currencyCode: $payment->total->currency,
            totalAmount: $totalAmount,
            buyer: new Buyer($payment->customer->email),
            products: [
                new Product(
                    name: $payment->description,
                    unitPrice: $totalAmount,
                    quantity: 1,
                ),
            ],
            extOrderId: (string) $payment->paymentId,
            notifyUrl: $this->configuration->notifyUrl,
            continueUrl: $this->configuration->continueUrl,
            payMethods: [],
            settings: null,
        );
    }

    /** @param OrderCreateRequest $submitRequest */
    public function submit(Payment $payment, CoreSubmitRequest $submitRequest): SubmissionResult
    {
        // TODO not implemented
        return new SubmissionResult('TODO', []);
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}
