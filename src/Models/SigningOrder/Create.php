<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\SigningOrder;

use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * @param string $role
     * @param string $email
     * @param int $order
     * @return void
     */
    public function enable(string $role, string $email, int $order): void
    {
        $this->data[] = [
            'type' => 'packet_signing_order',
            'attributes' => [
                'role_id' => $role,
                'email' => $email,
                'order' => $order,
            ],
        ];
    }
}
