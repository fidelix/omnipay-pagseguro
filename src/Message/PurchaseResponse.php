<?php

declare(strict_types=1);

namespace Omnipay\PagSeguro\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use function sprintf;
use function str_replace;
use function trim;

/**
 * PagSeguro Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return isset($this->data['error']) ? false : true;
    }

    public function isRedirect()
    {
        return $this->getRedirectUrl() !== null;
    }

    public function getRedirectUrl()
    {
        $request = $this->getRequest();

        if (!empty($this->data['code'])) {
            return sprintf(
                '%s/%s/payment.html?code=%s',
                str_replace('ws.', '', $request->getEndpoint()),
                trim($request->getResource(), '/'),
                $this->data['code']
            );
        }
        return;
    }
}
