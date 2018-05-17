<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entity\User;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class UserAttributes
 * @package AirSlate\ApiClient\Entity\User
 */
class UserAttributes
{
    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $email;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $first_name;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $last_name;

    /**
     * @var integer
     *
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    protected $status;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $created_at;

    /**
     * @var string
     *
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    protected $updated_at;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(array $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
