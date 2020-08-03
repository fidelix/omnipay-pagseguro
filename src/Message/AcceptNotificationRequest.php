<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use function http_build_query;
use function simplexml_load_string;
use function sprintf;
use const LIBXML_NOCDATA;

/*
 * PagSeguro Fetch Notification Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-notificacoes
 *
 */

class AcceptNotificationRequest extends AbstractRequest
{
    protected $endpoint        = 'https://ws.pagseguro.uol.com.br/v3';
    protected $sandboxEndpoint = 'https://ws.sandbox.pagseguro.uol.com.br/v3';
    protected $resource        = 'transactions/notifications';

    public function getNotificationCode()
    {
        return $this->getParameter('notificationCode');
    }

    public function setNotificationCode($value)
    {
        return $this->setParameter('notificationCode', $value);
    }

    public function sendData($data)
    {
        $this->validate('notificationCode');

        $url = sprintf(
            '%s/%s/%s?%s',
            $this->getEndpoint(),
            $this->getResource(),
            $this->getNotificationCode(),
            http_build_query($data, '', '&')
        );

        $httpResponse = $this->httpClient->request('GET', $url, $this->getHeaders());
        $xml = simplexml_load_string(
            $httpResponse->getBody()->getContents(),
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );

        $this->response = new AcceptNotificationResponse($this, $this->xml2array($xml));
        return $this->response;
    }

    public function createResponse($data)
    {
        return new AcceptNotificationResponse($this, $data);
    }
}
