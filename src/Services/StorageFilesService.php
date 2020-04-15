<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\StorageFile;
use AirSlate\ApiClient\Models\StorageFile\Upload as StorageFileModel;
use GuzzleHttp\RequestOptions;

/**
 * Class StorageFilesService
 *
 * @package AirSlate\ApiClient\Services
 */
class StorageFilesService extends AbstractService
{
    /**
     * @param StorageFileModel $model
     *
     * @return StorageFile
     *
     * @throws \Exception
     */
    public function create(StorageFileModel $model): StorageFile
    {
        $url = $this->resolveEndpoint('/storage-files');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return StorageFile::createFromOne($content);
    }

    /**
     * @param StorageFileModel $model
     * @param string $storageFileId
     *
     * @return StorageFile
     *
     * @throws \Exception
     */
    public function update(StorageFileModel $model, string $storageFileId): StorageFile
    {
        $url = $this->resolveEndpoint('/storage-files/' . $storageFileId);

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return StorageFile::createFromOne($content);
    }

    /**
     * @param string $storageFileId
     *
     * @return void
     *
     * @throws \Exception
     */
    public function delete(string $storageFileId): void
    {
        $url = $this->resolveEndpoint('/storage-files/' . $storageFileId);

        $this->httpClient->delete($url);
    }

    /**
     * @param string $storageFileId
     *
     * @return StorageFile
     *
     * @throws \Exception
     */
    public function one(string $storageFileId): StorageFile
    {
        $url = $this->resolveEndpoint('/storage-files/' . $storageFileId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return StorageFile::createFromOne($content);
    }

    /**
     * @param int|null $perPage
     * @param int|null $page
     *
     * @return array
     *
     * @throws \Exception
     */
    public function all(?int $perPage = null, ?int $page = null): array
    {
        $url = $this->resolveEndpoint('/storage-files');

        $response = $this->httpClient->get($url, [
            RequestOptions::QUERY => [
                'per_page' => $perPage,
                'page' => $page,
            ],
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return StorageFile::createFromCollection($content);
    }

    /**
     * @param string $storageFileUid
     *
     * @return StorageFile
     *
     * @throws \Exception
     */
    public function convertToPdf(string $storageFileUid): StorageFile
    {
        $url = $this->resolveEndpoint('/storage-files/' . $storageFileUid . '/convert-pdf');

        $response = $this->httpClient->post($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return StorageFile::createFromOne($content);
    }
}
