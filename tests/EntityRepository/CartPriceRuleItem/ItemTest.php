<?php
namespace inklabs\kommerce\EntityRepository\CartPriceRuleItem;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class ItemTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CartPriceRule',
        'kommerce:CartPriceRuleDiscount',
        'kommerce:CartPriceRuleItem\Item',
        'kommerce:Product',
    ];

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

        $cartPriceRule = $this->getDummyCartPriceRule();
        $cartPriceRule->addItem(new Entity\CartPriceRuleItem\Product($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleItem\Product($productPoster, 1));
        $cartPriceRule->addDiscount(new Entity\CartPriceRuleDiscount($productPoster));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($productPoster);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->flush();
        $this->entityManager->clear();
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
