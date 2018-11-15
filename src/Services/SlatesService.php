<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Entities\SlateInvite;
use AirSlate\ApiClient\Entities\SlateLinks;
use AirSlate\ApiClient\Entities\Slates\Document;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Models\Slate\Create;
use GuzzleHttp\RequestOptions;

/**
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
    public function packets(string $slateId): PacketsService
    {
        return (new PacketsService($this->httpClient))->setSlateId($slateId);
    }

    /**
     * @param string $slateId
     * @return TemplatesService
     */
    public function templates(string $slateId): TemplatesService
    {
        return (new TemplatesService($this->httpClient))->setSlateId($slateId);
    }

    /**
     * @param string $slateId
     * @return array|SlateInvite[]
     */
    public function invites(string $slateId): array
    {
        $url = $this->resolveEndpoint("/slates/$slateId/invites");
        
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateInvite::createFromCollection($content);
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
}
