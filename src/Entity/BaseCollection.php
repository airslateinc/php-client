<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class BaseCollection
 * @package AirSlate\ApiClient\Entity
 *
 * @Serializer\ExclusionPolicy("all")
 */
class BaseCollection extends BaseEntity implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("array<AirSlate\ApiClient\Entity\BaseData>")
     */
    protected $data;

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setItems(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $propertyValue
     * @param string $findBy
     *
     * @return Object|bool
     */
    public function get($propertyValue, $findBy = 'id')
    {
        $items = $this->getItems();
        $index = $this->getIndex($propertyValue, $findBy);
        if ($index !== false) {
            return $items[$index];
        }

        return false;
    }

    /**
     * @param object $object
     *
     * @return $this
     */
    public function add($object)
    {
        $this->data[] = $object;

        return $this;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator((array) $this->getItems());
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        $items = $this->getItems();

        return isset($items[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return object
     */
    public function offsetGet($offset)
    {
        $items = $this->getItems();

        return $items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $items = $this->getItems();
        $items[$offset] = $value;
        $this->setItems($items);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $items = $this->getItems();
        unset($items[$offset]);
        $this->setItems($items);
    }

    /**
     * @return int
     */
    public function count()
    {
        $items = $this->getItems();

        return count($items);
    }

    /**
     * @param string $propertyValue
     * @param string $findBy
     *
     * @return bool|string
     */
    protected function getIndex($propertyValue, $findBy = 'id')
    {
        $getter = 'get' . ucfirst($findBy);
        $items = $this->getItems();
        foreach ($items as $key => $item) {
            if ($item->$getter() == $propertyValue) {
                return $key;
            }
        }

        return false;
    }
}
