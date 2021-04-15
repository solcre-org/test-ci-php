<?php /** @noinspection ALL */

namespace BambooPayment\Service;

use BambooPayment\Core\AbstractService;
use BambooPayment\Entity\Purchase;

class PurchaseService extends AbstractService
{
    private const BASE_URI     = 'v1/api/purchase';
    private const ROLLBACK_URI = '/%s/rollback';
    private const REFUND_URI   = '/%s/refund';

    public function create(?array $params = null): Purchase
    {
        return $this->request('post', self::BASE_URI, $params);
    }

    public function fetch(int $id): Purchase
    {
        return $this->request('get', sprintf(self::BASE_URI . '/%s', $id));
    }

    public function refund(int $id): Purchase
    {
        return $this->request('post', sprintf(self::BASE_URI . self::REFUND_URI, $id));
    }

    public function getEntityClass(): string
    {
        return Purchase::class;
    }
}
