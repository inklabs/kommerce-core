<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper;
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

    public function testCRUD()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();

        $this->cartPriceRuleRepository->create($cartPriceRule);
        $this->assertSame(1, $cartPriceRule->getId());

        $cartPriceRule->setName('New Name');
        $this->assertSame(null, $cartPriceRule->getUpdated());

        $this->cartPriceRuleRepository->update($cartPriceRule);
        $this->assertTrue($cartPriceRule->getUpdated() instanceof DateTime);

        $this->cartPriceRuleRepository->delete($cartPriceRule);
        $this->assertSame(null, $cartPriceRule->getId());
    }

    public function testFind()
    {
        $this->setupCartPriceRuleDiscount();

        $this->setCountLogger();

        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(1);

        $cartPriceRule->getCartPriceRuleItems()->toArray();
        $cartPriceRule->getCartPriceRuleDiscounts()->toArray();

        $this->assertTrue($cartPriceRule instanceof CartPriceRule);
        $this->assertSame(4, $this->getTotalQueries());
    }
}
