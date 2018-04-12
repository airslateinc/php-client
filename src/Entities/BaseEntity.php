<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class BaseEntity
 * @package AirSlate\ApiClient\Entities
 */
class BaseEntity
{
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
     * @param array $jsonApi
     * @return static
     * @throws \Exception
     */
    public static function createFromOne(array $jsonApi)
    {
        if (!isset($jsonApi['data'])) {
            throw new \RuntimeException('Invalid data.');
        }

        $model = new static();
        $model->setAttribute('id', $jsonApi['data']['id']);
        $model->setAttributes($jsonApi['data']['attributes']);

        $model->relationships = $jsonApi['data']['relationships'] ?? [];
        $model->included = $jsonApi['included'] ?? [];

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
            throw new \RuntimeException('Invalid data.');
        }

        if (empty($jsonApi['data'])) {
            return [];
        }

        $models = [];
        foreach ($jsonApi['data'] as $datum) {
            $model = new static();
            $model->setAttribute('id', $datum['id']);
            $model->setAttributes($datum['attributes']);

            $model->relationships = $datum['relationships'] ?? [];
            $model->included = $jsonApi['included'] ?? [];

            $models[] = $model;
        }

        return $models;
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
            throw new \RuntimeException('No relation with such name.');
        }
        $data = $this->relationships[$relName];

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
}
