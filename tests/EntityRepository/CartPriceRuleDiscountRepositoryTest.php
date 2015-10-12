<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\tests\Helper;

class CartPriceRuleDiscountRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CartPriceRule',
        'kommerce:CartPriceRuleDiscount',
        'kommerce:AbstractCartPriceRuleItem',
        'kommerce:Product',
    ];

    /** @var CartPriceRuleDiscountRepositoryInterface */
    protected $cartPriceRuleDiscountRepository;

    public function setUp()
    {
        $this->cartPriceRuleDiscountRepository = $this->getRepositoryFactory()->getCartPriceRuleDiscountRepository();
    }

    public function setupCartPriceRuleDiscount()
    {
        $productShirt = $this->getDummyProduct(1);
        $productPoster = $this->getDummyProduct(2);

        $cartPriceRule = $this->getDummyCartPriceRule();
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($productPoster);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFindOneById()
    {
        $this->setupCartPriceRuleDiscount();

        $this->setCountLogger();

        $cartPriceRuleDiscount = $this->cartPriceRuleDiscountRepository->findOneById(1);

        $cartPriceRuleDiscount->getProduct()->getName();
        $cartPriceRuleDiscount->getCartPriceRule()->getName();

        $this->assertTrue($cartPriceRuleDiscount instanceof CartPriceRuleDiscount);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
