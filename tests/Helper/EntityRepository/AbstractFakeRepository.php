<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use Exception;
use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\EntityRepository\AbstractRepositoryInterface;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

class AbstractFakeRepository implements AbstractRepositoryInterface
{
    /** @var ValidationInterface[] */
    protected $entities = [];

    /** @var ValidationInterface */
    public $returnValue;

    /** @var Exception|null */
    public $crudExceptionToThrow;

    protected $entityName = 'Entity';

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

    /**
     * @param int $id
     * @return EntityInterface
     * @throws EntityNotFoundException
     */
    public function findOneById($id)
    {
        if (isset($this->entities[$id])) {
            return $this->entities[$id];
        }

        throw $this->getEntityNotFoundException();
    }

    protected function getEntityNotFoundException()
    {
        return new EntityNotFoundException($this->entityName . ' not found');
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

        $this->entities[$entity->getId()] = $entity;
    }

    public function create(EntityInterface & $entity)
    {
        $this->throwCrudExceptionIfSet();

        if (method_exists($entity, 'setId')) {
            $entity->setId($this->getAutoincrement());
        }

        $this->entities[$entity->getId()] = $entity;
    }

    public function remove(EntityInterface $entity)
    {
        $this->throwCrudExceptionIfSet();

        if (isset($this->entities[$entity->getId()])) {
            unset($this->entities[$entity->getId()]);
        }
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

    private function getAutoincrement()
    {
        if (count($this->entities) == 0) {
            return 1;
        }

        end($this->entities);
        $lastKey = key($this->entities);

        return $lastKey + 1;
    }
}
