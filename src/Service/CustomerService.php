<?php /** @noinspection ALL */

namespace BambooPayment\Service;

use BambooPayment\Core\AbstractService;
use BambooPayment\Entity\Customer;
use function sprintf;

class CustomerService extends AbstractService
{
    private const BASE_URI            = 'v1/api/customer';
    private const FETCH_USER_BY_EMAIL = 'v1/api/customer/GetCustomerByEmail';
    private const UPDATE_URI          = 'v1/api/customer/%s/update';

    public function create(?array $params = null): Customer
    {
        return $this->request('post', self::BASE_URI, $params);
    }

    public function delete(int $id, ?array $params = null): Customer
    {
        return $this->request('delete', sprintf(self::BASE_URI . '/%s', $id), $params);
    }

    public function fetch(int $id): Customer
    {
        return $this->request('get', sprintf(self::BASE_URI . '/%s', $id));
    }

    public function fetchByEmail(string $email): array
    {
        return $this->requestCollection(
            'get',
            self::FETCH_USER_BY_EMAIL,
            [
                'email' => $email
            ]
        );
    }

    public function update(int $id, ?array $params = null): Customer
    {
        return $this->request('post', sprintf(self::UPDATE_URI, $id), $params);
    }

    public function getEntityClass(): string
    {
        return Customer::class;
    }
}
