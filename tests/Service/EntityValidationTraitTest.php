<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\EntityValidatorException;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\InvalidEntity;

class EntityValidationTraitTest extends DoctrineTestCase
{
    use EntityValidationTrait;

    public function testThrowValidationErrors()
    {
        $validEntity = new InvalidEntity;
        $validEntity->setIsValid();

        $this->throwValidationErrors($validEntity);
    }

    public function testThrowValidationErrorsThrowsException()
    {
        $invalidEntity = new InvalidEntity;

        $this->setExpectedException(
            EntityValidatorException::class
        );

        $this->throwValidationErrors($invalidEntity);
    }
}
