<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Entities\SlateInvite;
use AirSlate\ApiClient\Entities\SlateLinks;
use AirSlate\ApiClient\Entities\Slates\Collaborator;
use AirSlate\ApiClient\Entities\Slates\Document;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Slate\Create;
use AirSlate\ApiClient\Models\Slate\Update;
use GuzzleHttp\RequestOptions;

/**
 * @deprecated
 * @see \AirSlate\ApiClient\Services\FlowsService
 *
 * Class SlatesService
 * @package AirSlate\ApiClient\Services
 */
class SlatesService extends AbstractService
{
    /**
     * @return Slate[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/slates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @return Slate
     * @throws \Exception
     */
    public function get(string $slateId): Slate
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @return PacketsService
     */
    public function packets(): PacketsService
    {
        return new PacketsService($this->httpClient);
    }

    /**
     * @return TemplatesService
     */
    public function templates(): TemplatesService
    {
        return new TemplatesService($this->httpClient);
    }

    /**
     * @param string $slateId
     * @return array|SlateInvite[]
     * @throws \Exception
     */
    public function invites(string $slateId): array
    {
        $url = $this->resolveEndpoint("/slates/$slateId/invites");
        
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateInvite::createFromCollection($content);
    }

    /**
     * @deprecated
     * @see \AirSlate\ApiClient\Services\FlowsService::invites with filters: ->addFilter('type', 'edit')
     *
     * @param string $slateId
     * @return array
     * @throws \Exception
     */
    public function collaborators(string $slateId): array
    {
        $url = $this->resolveEndpoint("/slates/$slateId/collaborators");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Collaborator::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @return SlateLinks
     * @throws \Exception
     */
    public function links(string $slateId): SlateLinks
    {
        $url = $this->resolveEndpoint("/slates/$slateId/links");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateLinks::createFromOne($content);
    }

    /**
     * @param Create $slate
     * @return Slate
     * @throws \Exception
     */
    public function create(Create $slate): Slate
    {
        $url = $this->resolveEndpoint('/slates');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @param Update $slate
     * @return Slate
     * @throws \Exception
     */
    public function update(string $slateId, Update $slate): Slate
    {
        $url = $this->resolveEndpoint("/slates/{$slateId}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $slateId
     *
     * @return bool
     *
     * @throws DomainException
     */
    public function checkAccess(string $slateId) : bool
    {
        $url = $this->resolveEndpoint("slates/{$slateId}/public");
        $result = true;

        try {
            $this->httpClient->get($url);
        } catch (DomainException $e) {
            if ($e->getCode() !== 403) {
                throw $e;
            }
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $documentUid
     *
     * @return Document
     */
    public function getDocumentType(string $documentUid) : Document
    {
        $url = $this->resolveEndpoint("slates/documents/{$documentUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromMeta($content);
    }

    /**
     * @return RolesService
     */
    public function roles(): RolesService
    {
        return new RolesService($this->httpClient);
    }

    /**
     * @return RoleDocumentsService
     */
    public function roleDocuments(): RoleDocumentsService
    {
        return new RoleDocumentsService($this->httpClient);
    }

    /**
     * @return TagsService
     */
    public function tags(): TagsService
    {
        return new TagsService($this->httpClient);
    }

    /**
     * @return RoleFieldsService
     */
    public function roleFields(): RoleFieldsService
    {
        return new RoleFieldsService($this->httpClient);
    }
}
