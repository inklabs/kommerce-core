<?php
namespace inklabs\kommerce\EntityRepository;

use Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;

abstract class AbstractRepository extends EntityRepository implements AbstractRepositoryInterface
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function update(EntityInterface & $entity)
    {
        $this->assertManaged($entity);
//        $this->assertChanged($entity);

        $this->flush();
    }

    public function create(EntityInterface & $entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    public function delete(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);
        $this->flush();
    }

    public function persist(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
    }

    public function flush()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }

    public function findOneById($id)
    {
        return $this->returnOrThrowNotFoundException(
            parent::find($id)
        );
    }

    protected function returnOrThrowNotFoundException($entity)
    {
        if ($entity === null) {
            throw $this->getEntityNotFoundException();
        }

        return $entity;
    }

    protected function getEntityNotFoundException()
    {
        return new EntityNotFoundException($this->getClassName() . ' not found');
    }

//    protected function getEntityNotModifiedException()
//    {
//        return new EntityNotModifiedException($this->getClassName() . ' not modified');
//    }

    private function assertManaged(EntityInterface $entity)
    {
        if (! $this->getEntityManager()->contains($entity)) {
            throw $this->getEntityNotFoundException();
        }
    }

//    private function assertChanged(EntityInterface $entity)
//    {
//        if ($this->isChanged($entity)) {
//            throw $this->getEntityNotModifiedException();
//        }
//    }

//    public function isChanged(EntityInterface $entity)
//    {
//        $unitOfWork = $this->getEntityManager()->getUnitOfWork();
//        $unitOfWork->computeChangeSets();
//        return $unitOfWork->isEntityScheduled($entity);
//    }
}
