<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\EntityManager\Exception;

use AirSlate\ApiClient\Entity\Errors;

/**
 * Class UnprocessableEntityException
 * @package AirSlate\ApiClient\EntityManager\Annotation
 */
class UnprocessableEntityException extends \Exception
{
    /**
     * @var Errors
     */
    protected $errorCollection;
    
    /**
     * @var array
     */
    protected $headers = [];
    
    /**
     * UnprocessableEntityException constructor.
     *
     * @param string|null $message
     * @param int $code
     * @param \Exception|null $previous
     * @param array $headers
     */
    public function __construct(
        string $message = null,
        int $code = 0,
        \Exception $previous = null,
        array $headers = array()
    ) {
        $this->headers = $headers;
        
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param Errors $errors
     */
    public function setErrors(Errors $errors)
    {
        $this->errorCollection = $errors;
    }

    /**
     * @return Errors
     */
    public function getErrors()
    {
        return $this->errorCollection;
    }
    
    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}
