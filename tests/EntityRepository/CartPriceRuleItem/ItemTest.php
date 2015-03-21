<?php
namespace inklabs\kommerce\EntityRepository\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class ItemTest extends Helper\DoctrineTestCase
{
    /**
     * @return Item
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRuleItem\Item');
    }

    public function setupCartPriceRuleItem()
    {
        $productShirt = $this->getDummyProduct(1);
        $productPoster = $this->getDummyProduct(2);

        $cartPriceRule = new Entity\CartPriceRule;
        $cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $cartPriceRule->setType(Entity\Promotion::TYPE_FIXED);
        $cartPriceRule->setValue(0);
        $cartPriceRule->addItem(new Entity\CartPriceRuleItem\Product($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleItem\Product($productPoster, 1));
        $cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($productPoster));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($productPoster);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function getDummyProduct($num)
    {
        $product = new Entity\Product;
        $product->setSku('TST' . $num);
        $product->setName('Test Product');
        $product->setDescription('Test product description');
        $product->setUnitPrice(500);
        $product->setQuantity(2);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);

        return $product;
    }

    public function testFind()
    {
        $this->setupCartPriceRuleItem();

        $this->setCountLogger();

        $cartPriceRuleItem = $this->getRepository()
            ->find(1);

        $cartPriceRuleItem->getProduct()->getName();
        $cartPriceRuleItem->getCartPriceRule()->getName();

        $this->assertTrue($cartPriceRuleItem instanceof Entity\CartPriceRuleItem\Item);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
