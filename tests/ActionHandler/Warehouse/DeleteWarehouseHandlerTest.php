<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\DeleteWarehouseCommand;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteWarehouseHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->persistEntityAndFlushClear($warehouse);
        $command = new DeleteWarehouseCommand($warehouse->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getWarehouseRepository()->findOneById(
            $command->getWarehouseId()
        );
    }
}
