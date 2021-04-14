<?php /** @noinspection ALL */

namespace BambooPayment\Service;

use BambooPayment\Core\AbstractService;
use BambooPayment\Entity\Purchase;

class PurchaseService extends AbstractService
{
    private const BASE_URI = 'v1/api/purchase';

    public function create(?array $params = null): Purchase
    {
        return $this->request('post', self::BASE_URI, Purchase::class, $params);
    }
}
