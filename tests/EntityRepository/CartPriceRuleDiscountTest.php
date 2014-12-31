<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CartPriceRuleDiscountTest extends Helper\DoctrineTestCase
{
    /**
     * @return CartPriceRuleDiscount
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRuleDiscount');
    }

    public function setUp()
    {
        $productShirt = new Entity\Product;
        $productShirt->setName('Shirt');
        $productShirt->setIsInventoryRequired(true);
        $productShirt->setIsPriceVisible(true);
        $productShirt->setIsActive(true);
        $productShirt->setIsVisible(true);
        $productShirt->setIsTaxable(true);
        $productShirt->setIsShippable(true);
        $productShirt->setShippingWeight(16);
        $productShirt->setQuantity(10);
        $productShirt->setUnitPrice(1200);

        $productPoster = new Entity\Product;
        $productPoster->setName('Poster');
        $productPoster->setIsInventoryRequired(true);
        $productPoster->setIsPriceVisible(true);
        $productPoster->setIsActive(true);
        $productPoster->setIsVisible(true);
        $productPoster->setIsTaxable(true);
        $productPoster->setIsShippable(true);
        $productPoster->setShippingWeight(16);
        $productPoster->setQuantity(10);
        $productPoster->setUnitPrice(500);

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

    public function testFind()
    {
        /* @var Entity\CartPriceRuleDiscount $cartPriceRuleDiscount */
        $cartPriceRuleDiscount = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $cartPriceRuleDiscount->getId());
        $this->assertSame(2, $cartPriceRuleDiscount->getProduct()->getId());
    }
}
