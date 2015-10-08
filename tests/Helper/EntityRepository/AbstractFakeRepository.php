<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use Exception;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\UpdatedTrait;
use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\EntityRepository\AbstractRepositoryInterface;

class AbstractFakeRepository implements AbstractRepositoryInterface
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

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getQueryBuilder()
    {
    }

    public function save(EntityInterface & $entity)
    {
        $this->throwCrudExceptionIfSet();

        if (method_exists($entity, 'setUpdated')) {
            $entity->setUpdated();
        }
    }

    public function create(EntityInterface & $entity)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function remove(EntityInterface $entity)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function persist(EntityInterface & $entity)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function merge(EntityInterface & $entity)
    {
    }

    public function flush()
    {
    }
}
