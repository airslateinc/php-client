<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\SlateAddonFile;
use AirSlate\ApiClient\Models\SlateAddonFile\Upload;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;

/**
 * @package AirSlate\ApiClient\Services
 */
class SlateAddonFileService extends AbstractService
{
    /**
     * @param string $slateAddonFileId
     * @return SlateAddonFile
     */
    public function get(string $slateAddonFileId): SlateAddonFile
    {
        $url = $this->resolveEndpoint(sprintf('/slate-addon-files/%s', $slateAddonFileId));

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddonFile::createFromOne($content);
    }

    /**
     * @param string $slateAddonFileId
     * @return StreamInterface
     */
    public function download(string $slateAddonFileId): StreamInterface
    {
        $url = $this->resolveEndpoint(sprintf('/slate-addon-files/%s/download', $slateAddonFileId));

        return $this->httpClient->get($url)->getBody();
    }

    /**
     * @param string $slateAddonFileId
     */
    public function delete(string $slateAddonFileId): void
    {
        $url = $this->resolveEndpoint(sprintf('/slate-addon-files/%s', $slateAddonFileId));

        $this->httpClient->delete($url);
    }

    /**
     * @param Upload $uploadIntent
     * @return SlateAddonFile
     */
    public function upload(Upload $uploadIntent): SlateAddonFile
    {
        $url = $this->resolveEndpoint('/slate-addon-files');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $uploadIntent->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddonFile::createFromOne($content);
    }
}
