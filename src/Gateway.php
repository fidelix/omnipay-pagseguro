<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\PagSeguro\Message\AcceptNotificationRequest;
use Omnipay\PagSeguro\Message\CompletePurchaseRequest;
use Omnipay\PagSeguro\Message\FindTransactionRequest;
use Omnipay\PagSeguro\Message\PreApprovalRequest;
use Omnipay\PagSeguro\Message\PurchaseRequest;
use Omnipay\PagSeguro\Message\RefundRequest;
use Omnipay\PagSeguro\Message\TransactionSearchRequest;

/**
 * PagSeguro Gateway
 *
 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/index.html
 *
 * @method ResponseInterface authorize(array $options = [])
 * @method ResponseInterface completeAuthorize(array $options = [])
 * @method ResponseInterface capture(array $options = [])
 * @method ResponseInterface void(array $options = [])
 * @method ResponseInterface createCard(array $options = [])
 * @method ResponseInterface updateCard(array $options = [])
 * @method ResponseInterface deleteCard(array $options = [])
 */

class Gateway extends AbstractGateway
{
    public const version = '3';

    public function getName()
    {
        return 'PagSeguro';
    }

    public function getDefaultParameters()
    {
        return [
            'email' => '',
            'token' => '',
            'sandbox' => false,
            'transactionReference' => '',
        ];
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getToken()
    {
        return $this->getParameter('token');
    }

    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    public function setSandbox($value)
    {
        return $this->setParameter('sandbox', $value);
    }

    public function getTransactionReference()
    {
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value)
    {
        return $this->setParameter('transactionReference', $value);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    public function transactionSearch(array $parameters = []) : Message\TransactionSearchRequest
    {
        return $this->createRequest(TransactionSearchRequest::class, $parameters);
    }

    public function fetchTransaction(array $parameters = []) : Message\FindTransactionRequest
    {
        return $this->createRequest(FindTransactionRequest::class, $parameters);
    }

    public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest(AcceptNotificationRequest::class, $parameters);
    }

    public function createPlan(array $parameters = [])
    {
        return $this->createRequest(PreApprovalRequest::class, $parameters);
    }

}
