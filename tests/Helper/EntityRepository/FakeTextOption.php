<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\TextOptionInterface;
use inklabs\kommerce\Entity;

class FakeTextOption extends AbstractFake implements TextOptionInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\TextOption);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllTextOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function save(Entity\TextOption & $textOption)
    {
    }

    public function create(Entity\TextOption & $textOption)
    {
    }

    public function remove(Entity\TextOption & $textOption)
    {
    }
}
