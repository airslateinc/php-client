<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\File as FileEntity;
use AirSlate\ApiClient\Models\File\Bulk as FileModel;
use GuzzleHttp\RequestOptions;

/**
 * Class UsersService
 * @package AirSlate\ApiClient\Services
 */
class FilesService extends AbstractService
{
    /**
     * Create files
     *
     * @param FileModel $file
     * @return FileEntity[]
     * @throws \Exception
     */
    public function bulk(FileModel $file): array
    {
        $url = $this->resolveEndpoint('/files/bulk');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $file->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FileEntity::createFromCollection($content);
    }

    /**
     * @param string $fileUid
     * @return FileEntity
     */
    public function get(string $fileUid): FileEntity
    {
        $url = $this->resolveEndpoint("/files/{$fileUid}");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return FileEntity::createFromOne($content);
    }
}
