<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\EntityManager\Exception;

use AirSlate\ApiClient\Entity\Errors;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UnprocessableEntityException
 * @package AirSlate\ApiClient\EntityManager\Annotation
 */
class UnprocessableEntityException extends UnprocessableEntityHttpException
{
    /**
     * @var Errors
     */
    protected $errorCollection;

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
}
