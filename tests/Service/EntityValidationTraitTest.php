<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Exception\EntityValidatorException;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Entity\InvalidEntity;

class EntityValidationTraitTest extends ServiceTestCase
{
    use EntityValidationTrait;

    public function testThrowValidationErrorsSingleValid()
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
