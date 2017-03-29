<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CartPriceRuleRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        CartPriceRuleDiscount::class,
        AbstractCartPriceRuleItem::class,
        Product::class,
    ];

    /** @var CartPriceRuleRepositoryInterface */
    protected $cartPriceRuleRepository;

    public function setUp()
    {
        parent::setUp();
        $this->cartPriceRuleRepository = $this->getRepositoryFactory()->getCartPriceRuleRepository();
    }

    public function setupCartPriceRuleDiscount()
    {
        $productShirt = $this->dummyData->getProduct();
        $productPoster = $this->dummyData->getProduct();

        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productShirt, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($productPoster);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $cartPriceRule;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->cartPriceRuleRepository,
            $this->dummyData->getCartPriceRule()
        );
    }

    public function testFind()
    {
        $originalCartPriceRule = $this->setupCartPriceRuleDiscount();

        $this->setCountLogger();

        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $originalCartPriceRule->getId()
        );

        $this->visitElements($cartPriceRule->getCartPriceRuleItems());
        $this->visitElements($cartPriceRule->getCartPriceRuleDiscounts());

        $this->assertTrue($cartPriceRule instanceof CartPriceRule);
        $this->assertSame(4, $this->getTotalQueries());
    }
}
