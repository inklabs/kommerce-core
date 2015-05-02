<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\OptionValueInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeOptionValue extends Helper\AbstractFake implements OptionValueInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\OptionValue);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\OptionValue & $optionValue)
    {
    }

    public function save(Entity\OptionValue & $optionValue)
    {
    }

    public function persist(Entity\OptionValue & $optionValue)
    {
    }
}
