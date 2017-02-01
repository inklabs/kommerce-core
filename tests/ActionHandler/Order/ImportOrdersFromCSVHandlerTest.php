<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportOrdersFromCSVHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $command1 = new ImportUsersFromCSVCommand(self::USERS_CSV_FILENAME);
        $command2 = new ImportOrdersFromCSVCommand(self::ORDERS_CSV_FILENAME);

        $this->dispatchCommand($command1);
        $this->dispatchCommand($command2);

        $this->entityManager->clear();
        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneByExternalId(
            'CO1102-0016'
        );
    }
}
