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

    /** @var CartPriceRuleDiscountInterface */
    protected $cartPriceRuleDiscountRepository;

    public function setUp()
    {
        $this->cartPriceRuleDiscountRepository = $this->repository()->getCartpriceRuleDiscount();
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

        $cartPriceRuleDiscount = $this->cartPriceRuleDiscountRepository->find(1);

        $cartPriceRuleDiscount->getProduct()->getName();
        $cartPriceRuleDiscount->getCartPriceRule()->getName();

        $this->assertTrue($cartPriceRuleDiscount instanceof Entity\CartPriceRuleDiscount);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
