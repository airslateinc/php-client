<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Entities\SlateInvite;
use AirSlate\ApiClient\Entities\SlateLinks;
use AirSlate\ApiClient\Entities\Slates\Document;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Slate\Create;
use AirSlate\ApiClient\Models\Slate\Update;
use Generator;
use GuzzleHttp\RequestOptions;

/**
 * Class FlowsService
 * @package AirSlate\ApiClient\Services
 */
class FlowsService extends AbstractService
{
    /**
     * @return PacketsService
     */
    public function packets(): PacketsService
    {
        return new PacketsService($this->httpClient);
    }

    /**
     * @return FlowTemplatesService
     */
    public function templates(): FlowTemplatesService
    {
        return new FlowTemplatesService($this->httpClient);
    }

    /**
     * @return TagsService
     */
    public function tags(): TagsService
    {
        return new TagsService($this->httpClient);
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
     * @return RoleFieldsService
     */
    public function roleFields(): RoleFieldsService
    {
        return new RoleFieldsService($this->httpClient);
    }
    
    /**
     * @return Slate[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/flows');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromCollection($content);
    }

    /**
     * @return Generator
     */
    public function collectionIterator(): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/flows');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield Slate::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }

    /**
     * @param string $flowId
     * @return Slate
     * @throws \Exception
     */
    public function get(string $flowId): Slate
    {
        $url = $this->resolveEndpoint('/flows/' . $flowId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param Create $slate
     * @return Slate
     * @throws \Exception
     */
    public function create(Create $slate): Slate
    {
        $url = $this->resolveEndpoint('/flows');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @return array|SlateInvite[]
     * @throws \Exception
     */
    public function invites(string $flowId): array
    {
        $url = $this->resolveEndpoint("/flows/$flowId/invites");
        
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateInvite::createFromCollection($content);
    }

    /**
     * @param string $flowId
     * @return SlateLinks
     * @throws \Exception
     */
    public function links(string $flowId): SlateLinks
    {
        $url = $this->resolveEndpoint("/flows/$flowId/links");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateLinks::createFromOne($content);
    }

    /**
     * @param string $flowId
     * @param Update $flow
     * @return Slate
     * @throws \Exception
     */
    public function update(string $flowId, Update $flow): Slate
    {
        $url = $this->resolveEndpoint("/flows/{$flowId}");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $flow->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $flowId
     *
     * @return bool
     *
     * @throws DomainException
     */
    public function checkAccess(string $flowId) : bool
    {
        $url = $this->resolveEndpoint("flows/{$flowId}/public");
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
        $url = $this->resolveEndpoint("flows/documents/{$documentUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Document::createFromMeta($content);
    }
}
