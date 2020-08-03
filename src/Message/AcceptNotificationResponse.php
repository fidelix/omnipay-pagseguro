<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;

/*
 * PagSeguro Fetch Notification Request
 *
 * https://dev.pagseguro.uol.com.br/docs/checkout-web-notificacoes
 *
 */

class AcceptNotificationResponse extends AbstractResponse implements NotificationInterface
{
    public function isSuccessful()
    {
        $data = $this->data;
        if ($data['status'] == 3) { // Paga
            return true;
        }
        return true;
    }

    public function getTransactionReference()
    {
        return $this->data['reference'];
    }

    public function getTransactionId()
    {
        return $this->data['code'];
    }

    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @inheritDoc
     */
    public function getTransactionStatus()
    {
        switch ($this->data['status']) {
            case 1:
            case 2:
                return NotificationInterface::STATUS_PENDING;
            case 3:
            case 4:
                return NotificationInterface::STATUS_COMPLETED;
        }
        return NotificationInterface::STATUS_FAILED;
    }

}
