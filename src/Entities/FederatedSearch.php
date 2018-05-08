<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class FederatedSearch
 * @package AirSlate\ApiClient\Entities
 *
 * @property string $id
 * @property string $slate_id
 * @property string $packet_id
 * @property array $highlight
 */

class FederatedSearch extends BaseEntity
{
    /**
     * @var string $type
     */
    protected $type = 'federated_search';
}
