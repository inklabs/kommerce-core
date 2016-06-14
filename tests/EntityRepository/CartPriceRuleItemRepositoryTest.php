<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CartPriceRuleItemRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        CartPriceRuleDiscount::class,
        AbstractCartPriceRuleItem::class,
        Product::class,
    ];

    /** @var CartPriceRuleItemRepositoryInterface */
    protected $cartPriceRuleItemRepository;

    public function setUp()
    {
        parent::setUp();
        $this->cartPriceRuleItemRepository = $this->getRepositoryFactory()->getCartPriceRuleItemRepository();
    }

    public function setupCartPriceRuleItem()
    {
        $productShirt = $this->dummyData->getProduct();
        $productPoster = $this->dummyData->getProduct();
        $cartPriceRuleItem = new CartPriceRuleProductItem($productShirt, 1);

        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRule->addItem($cartPriceRuleItem);
        $cartPriceRule->addItem(new CartPriceRuleProductItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($productPoster);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $cartPriceRuleItem;
    }

    public function testFind()
    {
        $originalCartPriceRuleItem = $this->setupCartPriceRuleItem();

        $this->setCountLogger();

        $cartPriceRuleItem = $this->cartPriceRuleItemRepository->findOneById(
            $originalCartPriceRuleItem->getId()
        );

        $cartPriceRuleItem->getProduct()->getName();
        $cartPriceRuleItem->getCartPriceRule()->getName();

        $this->assertEquals($originalCartPriceRuleItem->getId(), $cartPriceRuleItem->getId());
        $this->assertSame(3, $this->getTotalQueries());
    }
}
