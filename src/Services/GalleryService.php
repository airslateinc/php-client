<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\GalleryItem;
use AirSlate\ApiClient\Models\Gallery\AddGalleryItem;
use AirSlate\ApiClient\Models\Gallery\GalleryFile;
use GuzzleHttp\RequestOptions;

class GalleryService extends AbstractService
{
    /**
     * @param AddGalleryItem $galleryItems
     * @return GalleryItem
     */
    public function addGalleryItem(AddGalleryItem $galleryItems)
    {
        $url = $this->resolveEndpoint("/gallery/gallery-items");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $galleryItems->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return GalleryItem::createFromOne($content);
    }

    /**
     * @param string $galleryItemId
     * @return GalleryItem
     */
    public function getGalleryItem(string $galleryItemId)
    {
        $url = $this->resolveEndpoint("/gallery/gallery-items/$galleryItemId");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return GalleryItem::createFromOne($content);
    }

    /**
     * @param string[] $types
     * @return array
     */
    public function getGalleryItemsByCurrentUser(array $types): array
    {
        $url = $this->resolveEndpoint('/gallery/gallery-items/byUser');

        $response = $this->httpClient->get($url, [
            'query' => [
                'types' => $types,
            ],
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return GalleryItem::createFromCollection($content);
    }

    /**
     * @param string $galleryItemId
     */
    public function deleteGalleryItem(string $galleryItemId): void
    {
        $url = $this->resolveEndpoint("/gallery/gallery-items/$galleryItemId");

        $this->httpClient->delete($url);
    }

    /**
     * @param string $galleryItemId
     */
    public function setDefaultGalleryItem(string $galleryItemId): void
    {
        $url = $this->resolveEndpoint("/gallery/gallery-items/setDefault/$galleryItemId");

        $this->httpClient->patch($url);
    }

    /**
     * @param GalleryFile $file
     * @return string
     */
    public function uploadFile(GalleryFile $file)
    {
        $url = $this->resolveEndpoint('/gallery/gallery-items/file-upload');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $file->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content['file_id'];
    }
}
