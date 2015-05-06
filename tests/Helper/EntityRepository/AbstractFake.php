<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity;

class AbstractFake
{
    /** @var Entity\EntityInterface */
    public $returnValue;

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

    public function setReturnValue(Entity\EntityInterface $returnValue = null)
    {
        $this->returnValue = $returnValue;
    }

    public function flush()
    {
    }
}
