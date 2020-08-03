<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use function array_merge;
use function sprintf;

class PreApprovalRequest extends AbstractRequest
{
    protected $resource = 'pre-approvals/request';

    public function setBillingMode($value)
    {
        return $this->setParameter('billingMode', $value);
    }
    public function setFrequency($value)
    {
        return $this->setParameter('frequency', $value);
    }
    public function setAmountPerPayment($value)
    {
        return $this->setParameter('amountPerPayment', $value);
    }
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }
    public function setReviewUrl($value)
    {
        return $this->setParameter('reviewUrl', $value);
    }
    public function getFrequency($value)
    {
        return $this->getParameter('frequency');
    }

    public function getData()
    {
        $this->validate('currency', 'transactionReference');

        $data = [
            'currency' => $this->getCurrency(),
            'reference' => $this->getTransactionReference(),
            'redirectURL' => $this->getReturnUrl(),
            'notificationURL' => $this->getNotifyUrl(),
            'preApprovalCharge' => $this->getParameter('billingMode'),
            'preApprovalPeriod' => $this->getParameter('frequency'),
            'preApprovalAmountPerPayment' => $this->formatCurrency($this->getParameter('amountPerPayment')),
            'preApprovalDetails' => $this->getDescription(),
            'preApprovalName' => $this->getParameter('name'),
            'reviewURL' => $this->getParameter('reviewUrl'),
        ];

        return array_merge(
            parent::getData(),
            $data
        );
    }

    public function sendData($data)
    {
        $url = sprintf(
            '%s/%s?%s',
            $this->getEndpoint(),
            trim($this->getResource(), '/'),
            http_build_query($data, '', '&')
        );
        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url, $this->getHeaders());
        $xml = simplexml_load_string(
            $httpResponse->getBody()->getContents(),
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );

        return $this->createResponse($this->xml2array($xml));
    }

    protected function createResponse($data)
    {
        return $this->response = new PreApprovalResponse($this, $data);
    }
}
