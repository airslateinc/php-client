<?php

namespace AirSlate\ApiClient\Entities;

/**
 * Class JsonEntity
 * @package AirSlate\UsersManagement\Entities
 */
class JsonEntity
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes) || isset($this->attributes[$name])) {
            return $this->attributes[$name];
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
    public function setAttributes($values): void
    {
        $this->attributes = $values;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

}
