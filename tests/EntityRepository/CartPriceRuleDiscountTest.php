<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class CartPriceRuleDiscountTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CartPriceRule',
        'kommerce:CartPriceRuleDiscount',
        'kommerce:CartPriceRuleItem\Item',
        'kommerce:Product',
    ];

    /**
     * @return CartPriceRuleDiscount
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRuleDiscount');
    }

    public function setupCartPriceRuleDiscount()
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
        $this->setupCartPriceRuleDiscount();

        $this->setCountLogger();

        $cartPriceRuleDiscount = $this->getRepository()
            ->find(1);

        $cartPriceRuleDiscount->getProduct()->getName();
        $cartPriceRuleDiscount->getCartPriceRule()->getName();

        $this->assertTrue($cartPriceRuleDiscount instanceof Entity\CartPriceRuleDiscount);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
