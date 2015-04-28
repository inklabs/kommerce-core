<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Entity\EntityInterface;

class AbstractFake
{
    /** @var Entity\EntityInterface */
    public $returnValue;

    public function __call($a, $b)
    {
    }

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
}
