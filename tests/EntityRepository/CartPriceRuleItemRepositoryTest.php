<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class CartPriceRuleItemRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CartPriceRule',
        'kommerce:CartPriceRuleDiscount',
        'kommerce:AbstractCartPriceRuleItem',
        'kommerce:Product',
    ];

    /**
     * @return CartPriceRuleItemRepository
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:AbstractCartPriceRuleItem');
    }

    public function setupCartPriceRuleItem()
    {
        $productShirt = $this->getDummyProduct(1);
        $productPoster = $this->getDummyProduct(2);

        $cartPriceRule = $this->getDummyCartPriceRule();
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new Entity\CartPriceRuleProductItem($productPoster, 1));
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

        $this->assertTrue($cartPriceRuleItem instanceof Entity\AbstractCartPriceRuleItem);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
