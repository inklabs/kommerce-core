<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ImportOrderItemsFromCSVCommand;
use inklabs\kommerce\Action\Order\ImportOrdersFromCSVCommand;
use inklabs\kommerce\Action\User\ImportUsersFromCSVCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ImportOrderItemsFromCSVHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        OrderItem::class,
        Product::class,
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $this->setupProductsForImport();
        $command1 = new ImportUsersFromCSVCommand(self::USERS_CSV_FILENAME);
        $command2 = new ImportOrdersFromCSVCommand(self::ORDERS_CSV_FILENAME);
        $command3 = new ImportOrderItemsFromCSVCommand(self::ORDER_ITEMS_CSV_FILENAME);

        $this->dispatchCommand($command1);
        $this->dispatchCommand($command2);
        $this->dispatchCommand($command3);

        $this->entityManager->clear();
        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneByExternalId(
            'CO1102-0016'
        );
        $this->assertSame('SKU12CNR', $order->getOrderItems()[0]->getSku());
    }

    private function setupProductsForImport()
    {
        $products = [
            $this->dummyData->getProduct('SKU03BAN'),
            $this->dummyData->getProduct('SKU03BOP'),
            $this->dummyData->getProduct('SKU03CCM'),
            $this->dummyData->getProduct('SKU03ODR'),
            $this->dummyData->getProduct('SKU03SPC'),
            $this->dummyData->getProduct('SKU03VAN'),
            $this->dummyData->getProduct('SKU06BAN'),
            $this->dummyData->getProduct('SKU06BLC'),
            $this->dummyData->getProduct('SKU06BOP'),
            $this->dummyData->getProduct('SKU06ODR'),
            $this->dummyData->getProduct('SKU06VAN'),
            $this->dummyData->getProduct('SKU12BAN'),
            $this->dummyData->getProduct('SKU12BOP'),
            $this->dummyData->getProduct('SKU12CCM'),
            $this->dummyData->getProduct('SKU12CNR'),
            $this->dummyData->getProduct('SKU12COL'),
            $this->dummyData->getProduct('SKU12LVS'),
            $this->dummyData->getProduct('SKU12ODR'),
            $this->dummyData->getProduct('SKU12SPC'),
            $this->dummyData->getProduct('SKU12VAN'),
            $this->dummyData->getProduct('SKUFFF'),
            $this->dummyData->getProduct('SKUFFL'),
            $this->dummyData->getProduct('SKUGRN'),
            $this->dummyData->getProduct('SKUSND'),
            $this->dummyData->getProduct('SKUTBR'),
            $this->dummyData->getProduct('SKUTCR'),
        ];

        foreach ($products as $product) {
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
    }
}
