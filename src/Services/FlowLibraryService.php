<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

/**
 * Class FlowLibraryService
 * @package AirSlate\ApiClient\Services
 */
class FlowLibraryService extends AbstractService
{
    /**
     * @var DocumentTemplatesService
     */
    private $documentTemplatesService;

    public function documentTemplates(): DocumentTemplatesService
    {
        if (!$this->documentTemplatesService) {
            $this->documentTemplatesService = new DocumentTemplatesService($this->httpClient);
        }

        return $this->documentTemplatesService;
    }
}
