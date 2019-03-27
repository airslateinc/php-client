<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Entities\DocumentPermissions\CustomOptions;
use AirSlate\ApiClient\Entities\DocumentPermissions\EnableComments;
use AirSlate\ApiClient\Entities\DocumentPermissions\EnableToolbar;

/**
 * Class DocumentPermissions
 * @package AirSlate\ApiClient\Entities
 *
 * @property bool $can_read
 * @property bool $can_construct
 * @property bool $can_fill
 * @property bool $can_download
 * @property bool $enable_validation
 * @property array $custom_options
 */
class DocumentPermissions extends BaseEntity
{
    /** @var string */
    protected $type = 'document_permissions';

    /**
     * @return bool
     */
    public function hasPermissions(): bool
    {
        return !$this->getMeta('permissions-missed');
    }

    /**
     * @return bool
     */
    public function canRead(): bool
    {
        return $this->can_read;
    }

    /**
     * @return bool
     */
    public function canConstruct(): bool
    {
        return $this->can_construct;
    }

    /**
     * @return bool
     */
    public function canFill(): bool
    {
        return $this->can_fill;
    }

    /**
     * @return bool
     */
    public function canDownload(): bool
    {
        return $this->can_download;
    }

    /**
     * @return bool
     */
    public function isEnableValidation(): bool
    {
        return $this->enable_validation;
    }

    /**
     * @return CustomOptions
     */
    public function customOptions(): CustomOptions
    {
        return new CustomOptions(
            new EnableComments(
                $this->custom_options['enable_comments']['value'],
                $this->custom_options['enable_comments']['override']
            ),
            new EnableToolbar(
                $this->custom_options['enable_toolbar']['value'],
                $this->custom_options['enable_toolbar']['override']
            )
        );
    }
}
