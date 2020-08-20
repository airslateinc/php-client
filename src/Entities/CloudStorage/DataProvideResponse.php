<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\CloudStorage;

use AirSlate\ApiClient\Entities\BaseEntity;

/**
 * Class DataProvideResponse
 * @package AirSlate\ApiClient\Entities\CloudStorage
 *
 * @property array $data
 */
class DataProvideResponse extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = 'data_provide_response';
}
