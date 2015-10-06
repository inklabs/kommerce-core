<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use Exception;
use inklabs\kommerce\Entity\ValidationInterface;

class AbstractFakeRepository
{
    /** @var ValidationInterface */
    public $returnValue;

    /** @var Exception|null */
    public $crudExceptionToThrow;

    protected function getReturnValue()
    {
        return $this->returnValue;
    }

    protected function getReturnValueAsArray()
    {
        if ($this->returnValue === null) {
            return [];
        }

        return [$this->returnValue];
    }

    public function setReturnValue(ValidationInterface $returnValue = null)
    {
        $this->returnValue = $returnValue;
    }

    public function setCrudException(Exception $exception)
    {
        $this->crudExceptionToThrow = $exception;
    }

    public function throwCrudExceptionIfSet()
    {
        if ($this->crudExceptionToThrow !== null) {
            throw $this->crudExceptionToThrow;
        }
    }

    public function flush()
    {
    }
}
