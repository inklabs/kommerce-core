<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Warehouse implements ViewInterface
{
    public $id;
    public $name;
    public $created;
    public $updated;

    /** @var Address */
    public $address;

    public function __construct(Entity\Warehouse $warehouse)
    {
        $this->id      = $warehouse->getId();
        $this->name    = $warehouse->getName();
        $this->address = $warehouse->getAddress()->getView();
        $this->created = $warehouse->getCreated();
        $this->updated = $warehouse->getUpdated();
    }

    public function export()
    {
        return $this;
    }
}
