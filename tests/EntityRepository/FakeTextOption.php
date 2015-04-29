<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\TextOptionInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeTextOption extends Helper\AbstractFake implements TextOptionInterface
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

    public function create(Entity\TextOption & $textOption)
    {
    }

    public function save(Entity\TextOption & $textOption)
    {
    }

    public function persist(Entity\TextOption & $textOption)
    {
    }
}
