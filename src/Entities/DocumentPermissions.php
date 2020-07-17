<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Entities\DocumentPermissions\CustomOptions;
use AirSlate\ApiClient\Entities\DocumentPermissions\EnableComments;
use AirSlate\ApiClient\Entities\DocumentPermissions\EnableToolbar;
use AirSlate\ApiClient\Entities\DocumentPermissions\ShowConstructor;

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
    protected $type = EntityType::DOCUMENT_PERMISSION;

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
                $this->custom_options['enable_comments']['value'] ?? false,
                $this->custom_options['enable_comments']['override'] ?? false
            ),
            new EnableToolbar(
                $this->custom_options['enable_toolbar']['value'] ?? false,
                $this->custom_options['enable_toolbar']['override'] ?? false
            ),
            new ShowConstructor(
                $this->custom_options['show_constructor']['value'] ?? true,
                $this->custom_options['show_constructor']['override'] ?? false
            )
        );
    }
}
