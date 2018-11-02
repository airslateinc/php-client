<?php

namespace AirSlate\ApiClient\Models\Document;

use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class AddAttachments
 * @package AirSlate\ApiClient\Models\Document
 */
class AddAttachments extends AbstractModel
{
    /**
     * @param array $attachment
     */
    public function addAttachment(array $data)
    {
        $this->data[] = $data;
    }
}
