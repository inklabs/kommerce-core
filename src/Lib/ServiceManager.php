<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Exception\ValidatorException;

class ServiceManager
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByEncodedId($encodedId)
    {
        return $this->find(Lib\BaseConvert::decode($encodedId));
    }

    protected function throwValidationErrors(Entity\EntityInterface $entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($entity);

        if (count($errors) > 0) {
            $exception = new ValidatorException;
            $exception->errors = $errors;
            throw $exception;
        }
    }
}
