<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\Action\Order\ImportPaymentsFromCSVCommand;
use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportPaymentsFromCSVHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        User::class,
        TaxRate::class,
        Cart::class,
        AbstractPayment::class,
    ];

    public function testHandle()
    {
        $command1 = new ImportUsersFromCSVCommand(self::USERS_CSV_FILENAME);
        $command2 = new ImportOrdersFromCSVCommand(self::ORDERS_CSV_FILENAME);
        $command3 = new ImportPaymentsFromCSVCommand(self::ORDER_PAYMENTS_CSV_FILENAME);

        $this->dispatchCommand($command1);
        $this->dispatchCommand($command2);
        $this->dispatchCommand($command3);

        $this->entityManager->clear();
        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneByExternalId(
            'CO1102-0016'
        );
        $this->assertSame(1600, $order->getPayments()[0]->getAmount());
    }
}
