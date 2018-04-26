<?php

namespace AirSlate\ApiClient\Entities;

use AirSlate\ApiClient\Exceptions\MissingDataException;
use AirSlate\ApiClient\Exceptions\RelationNotExistException;
use AirSlate\ApiClient\Exceptions\TypeMismatchException;
use AirSlate\ApiClient\Helpers\Inflector;

/**
 * Class BaseEntity
 * @package AirSlate\ApiClient\Entities
 */
class BaseEntity
{
    /**
     * Type of the JSON:API resource.
     * @var string
     */
    protected $type;
    /**
     * @var array
     */
    private $attributes = [];
    /**
     * @var array
     */
    private $relationships = [];
    /**
     * @var array
     */
    private $included = [];
    /**
     * @var array
     */
    private $meta = [];

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes) || isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        try {
            return $this->__get($name) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        if (!empty($this->type)) {
            return $this->type;
        }

        return Inflector::tableize(basename(str_replace('\\', '/', static::class)));
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param $values
     */
    public function setAttributes(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setAttribute(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param null|string $name
     * @return array|string|null
     */
    public function getMeta(?string $name = null)
    {
        return (null === $name) ?
            $this->meta :
            ($this->meta[$name] ?? null);
    }

    /**
     * @param array $jsonApi
     * @return static
     * @throws \Exception
     */
    public static function createFromOne(array $jsonApi)
    {
        if (!isset($jsonApi['data'])) {
            throw new MissingDataException();
        }

        $model = new static();

        if (($jsonApi['data']['type'] ?? '') !== $model->getType()) {
            throw new TypeMismatchException();
        }

        $model->setAttribute('id', $jsonApi['data']['id']);
        $model->setAttributes($jsonApi['data']['attributes']);

        $model->relationships = $jsonApi['data']['relationships'] ?? [];
        $model->included = $jsonApi['included'] ?? [];
        $model->meta = $jsonApi['meta'] ?? [];

        return $model;
    }

    /**
     * @param array $jsonApi
     * @return array
     * @throws \Exception
     */
    public static function createFromCollection(array $jsonApi): array
    {
        if (!isset($jsonApi['data'])) {
            throw new MissingDataException();
        }

        if (empty($jsonApi['data'])) {
            return [];
        }

        $models = [];
        foreach ($jsonApi['data'] as $datum) {
            $model = new static();

            if (($datum['type'] ?? '') !== $model->getType()) {
                throw new TypeMismatchException();
            }

            $model->setAttribute('id', $datum['id']);
            $model->setAttributes($datum['attributes']);

            $model->relationships = $datum['relationships'] ?? [];
            $model->included = $jsonApi['included'] ?? [];

            $models[] = $model;
        }

        return $models;
    }

    /**
     * @param array $jsonApi
     * @return static
     */
    public static function createFromMeta(array $jsonApi)
    {
        $model = new static();
        $model->meta = $jsonApi['meta'] ?? [];

        return $model;
    }

    /**
     * @param string $className
     * @param string $relName
     * @return null|BaseEntity
     * @throws \Exception
     */
    protected function hasOne(string $className, string $relName): ?BaseEntity
    {
        if (!array_key_exists($relName, $this->relationships)) {
            throw new RelationNotExistException();
        }
        $data = $this->relationships[$relName]['data'] ?? null;

        if (null === $data) {
            return null;
        }

        $relation = array_filter($this->included, function ($item) use ($data) {
            return ($item['type'] === $data['type']) && ($item['id'] === $data['id']);
        });

        if (empty($relation)) {
            /** @var BaseEntity $relation */
            $relation = new $className();
            $relation->setAttribute('id', $data['id']);

            return $relation;
        }

        /** @var BaseEntity $className */
        return $className::createFromOne(['data' => reset($relation)]);
    }

    /**
     * @param string $className
     * @param string $relName
     * @return array
     * @throws \Exception
     */
    protected function hasMany(string $className, string $relName): array
    {
        if (!array_key_exists($relName, $this->relationships)) {
            throw new RelationNotExistException();
        }
        $data = $this->relationships[$relName]['data'] ?? [];

        if ([] === $data) {
            return [];
        }

        $ids = array_column($data, 'type', 'id');

        $relations = array_filter($this->included, function ($item) use ($ids) {
            return ($item['type'] === $ids[$item['id']]) && array_key_exists($item['id'], $ids);
        });

        if (empty($relations)) {
            return array_map(function ($key) use ($className) {
                /** @var BaseEntity $model */
                $model = new $className();
                $model->setAttribute('id', $key);

                return $model;
            }, array_keys($ids));
        }

        /** @var BaseEntity $className */
        return $className::createFromCollection(['data' => $relations]);
    }
}
