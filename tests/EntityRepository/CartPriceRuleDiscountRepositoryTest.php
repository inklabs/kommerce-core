<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CartPriceRuleDiscountRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        CartPriceRuleDiscount::class,
        AbstractCartPriceRuleItem::class,
        Product::class,
    ];

    /** @var CartPriceRuleDiscountRepositoryInterface */
    protected $cartPriceRuleDiscountRepository;

    public function setUp()
    {
        parent::setUp();
        $this->cartPriceRuleDiscountRepository = $this->getRepositoryFactory()->getCartPriceRuleDiscountRepository();
    }

    public function setupCartPriceRuleDiscount()
    {
        $productShirt = $this->dummyData->getProduct(1);
        $productPoster = $this->dummyData->getProduct(2);

        $cartPriceRule = $this->dummyData->getCartPriceRule();
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
        $this->assertSame(1, $this->getTotalQueries());
    }
}
