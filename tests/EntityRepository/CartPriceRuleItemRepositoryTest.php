<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\tests\Helper;

class CartPriceRuleItemRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CartPriceRule',
        'kommerce:CartPriceRuleDiscount',
        'kommerce:AbstractCartPriceRuleItem',
        'kommerce:Product',
    ];

    /** @var CartPriceRuleItemRepositoryInterface */
    protected $cartPriceRuleItemRepository;

    public function setUp()
    {
        $this->cartPriceRuleItemRepository = $this->getRepositoryFactory()->getCartPriceRuleItemRepository();
    }

    public function setupCartPriceRuleItem()
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

    public function testFind()
    {
        $this->setupCartPriceRuleItem();

        $this->setCountLogger();

        $cartPriceRuleItem = $this->cartPriceRuleItemRepository->findOneById(1);

        $cartPriceRuleItem->getProduct()->getName();
        $cartPriceRuleItem->getCartPriceRule()->getName();

        $this->assertTrue($cartPriceRuleItem instanceof AbstractCartPriceRuleItem);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
