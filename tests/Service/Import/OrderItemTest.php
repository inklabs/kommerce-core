<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class OrderItemTest extends Helper\DoctrineTestCase
{
    public function testImport()
    {
        $this->setupProductsForImport();
        $this->setupOrdersForImport();

        $this->setCountLogger();

        $orderItemService = new OrderItem($this->entityManager);

        $iterator = new Lib\CSVIterator(__DIR__ . '/OrderItemTest.csv');
        $importedCount = $orderItemService->import($iterator);

        $this->assertSame(37, $importedCount);
        $this->assertSame(111, $this->countSQLLogger->getTotalQueries());
    }

    private function setupOrdersForImport()
    {
        $cartTotal = $this->getDummyCartTotal();

        $order1 = $this->getDummyOrder($cartTotal);
        $order2 = $this->getDummyOrder($cartTotal);
        $order3 = $this->getDummyOrder($cartTotal);

        $order1->setExternalId('CO1102-0016');
        $order2->setExternalId('CO1103-0027');
        $order3->setExternalId('CO1104-0032');

        $this->entityManager->persist($order1);
        $this->entityManager->persist($order2);
        $this->entityManager->persist($order3);

        $this->entityManager->flush();
    }

    private function setupProductsForImport()
    {
        $products = [
            $this->getDummyProduct('SKU03BAN'),
            $this->getDummyProduct('SKU03BOP'),
            $this->getDummyProduct('SKU03CCM'),
            $this->getDummyProduct('SKU03ODR'),
            $this->getDummyProduct('SKU03SPC'),
            $this->getDummyProduct('SKU03VAN'),
            $this->getDummyProduct('SKU06BAN'),
            $this->getDummyProduct('SKU06BLC'),
            $this->getDummyProduct('SKU06BOP'),
            $this->getDummyProduct('SKU06ODR'),
            $this->getDummyProduct('SKU06VAN'),
            $this->getDummyProduct('SKU12BAN'),
            $this->getDummyProduct('SKU12BOP'),
            $this->getDummyProduct('SKU12CCM'),
            $this->getDummyProduct('SKU12CNR'),
            $this->getDummyProduct('SKU12COL'),
            $this->getDummyProduct('SKU12LVS'),
            $this->getDummyProduct('SKU12ODR'),
            $this->getDummyProduct('SKU12SPC'),
            $this->getDummyProduct('SKU12VAN'),
            $this->getDummyProduct('SKUFFF'),
            $this->getDummyProduct('SKUFFL'),
            $this->getDummyProduct('SKUGRN'),
            $this->getDummyProduct('SKUSND'),
            $this->getDummyProduct('SKUTBR'),
            $this->getDummyProduct('SKUTCR'),
        ];

        foreach ($products as $product) {
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
    }
}
