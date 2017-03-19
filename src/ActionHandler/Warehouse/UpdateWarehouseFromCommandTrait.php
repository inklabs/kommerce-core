<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\AbstractWarehouseCommand;
use inklabs\kommerce\Entity\Warehouse;

trait UpdateWarehouseFromCommandTrait
{
    public function updateWarehouseFromCommand(Warehouse $warehouse, AbstractWarehouseCommand $command)
    {
        $warehouse->setName($command->getName());
        $address = $warehouse->getAddress();
        $address->setAttention($command->getAttention());
        $address->setCompany($command->getCompany());
        $address->setAddress1($command->getAddress1());
        $address->setAddress2($command->getAddress2());
        $address->setCity($command->getCity());
        $address->setState($command->getState());
        $address->setZip5($command->getZip5());
        $address->setZip4($command->getZip4());
        $point = $address->getPoint();
        $point->setLatitude($command->getLatitude());
        $point->setLongitude($command->getLongitude());
    }
}
