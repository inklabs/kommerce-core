<?php
namespace inklabs\kommerce\EntityRepository;

use Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;
use inklabs\kommerce\Service\EntityValidationTrait;

abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    use EntityValidationTrait;

    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function create(EntityInterface & $entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    public function update(EntityInterface & $entity): void
    {
        $this->assertManaged($entity);
        $this->throwValidationErrors($entity);
        $this->flush();
    }

    public function delete(EntityInterface $entity): void
    {
        $this->remove($entity);
        $this->flush();
    }

    public function remove(EntityInterface $entity): void
    {
        $this->getEntityManager()
            ->remove($entity);
    }

    public function persist(EntityInterface & $entity): void
    {
        $this->throwValidationErrors($entity);
        $this->getEntityManager()
            ->persist($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()
            ->flush();
    }

    public function findOneById(UuidInterface $id)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['id' => $id])
        );
    }

    protected function returnOrThrowNotFoundException($entity, $className = null)
    {
        if ($entity === null) {
            throw $this->getEntityNotFoundException($className);
        }

        return $entity;
    }

    protected function getEntityNotFoundException($className = null)
    {
        if ($className === null) {
            $className = $this->getClassName();
        }

        return new EntityNotFoundException($className . ' not found');
    }

    private function assertManaged(EntityInterface $entity)
    {
        if (! $this->getEntityManager()->contains($entity)) {
            throw $this->getEntityNotFoundException();
        }
    }
}
