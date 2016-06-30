<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CartRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
        Cart::class,
        CartItem::class,
        Product::class,
        User::class,
        TaxRate::class,
    ];

    /** @var CartRepositoryInterface */
    protected $cartRepository;

    public function setUp()
    {
        parent::setUp();
        $this->cartRepository = $this->getRepositoryFactory()->getCartRepository();
    }

    public function setupCart($sessionId = '')
    {
        $product = $this->dummyData->getProduct();

        $user = $this->dummyData->getUser();
        $cartItem = $this->dummyData->getCartItem($product);

        $taxRate = $this->dummyData->getTaxRate();

        $cart = $this->dummyData->getCart();
        $cart->setSessionId($sessionId);
        $cart->addCartItem($cartItem);
        $cart->setUser($user);
        $cart->setTaxRate($taxRate);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->cartRepository->create($cart);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $cart;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->cartRepository,
            $this->dummyData->getCart()
        );
    }

    public function testFindOneByUuId()
    {
        $originalCart = $this->setupCart();
        $this->setCountLogger();

        $cart = $this->cartRepository->findOneById($originalCart->getId());

        $cart->getUser()->getCreated();
        $cart->getTaxRate()->getCreated();
        $this->visitElements($cart->getCartItems());
        $this->visitElements($cart->getCoupons());

        $this->assertEntitiesEqual($originalCart, $cart);
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testFindByUser()
    {
        $originalCart = $this->setupCart();
        $this->setCountLogger();

        $cart = $this->cartRepository->findOneByUserId(
            $originalCart->getUser()->getId()
        );

        $this->assertEntitiesEqual($originalCart, $cart);
    }

    public function testFindBySession()
    {
        $sessionId = self::SESSION_ID;
        $originalCart = $this->setupCart($sessionId);
        $this->setCountLogger();

        $cart = $this->cartRepository->findOneBySession($sessionId);

        $this->assertEntitiesEqual($originalCart, $cart);
    }

    public function testGetItemById()
    {
        $cart1 = $this->setupCart();
        $cartItem1 = $cart1->getCartItems()[0];

        $cartItem = $this->cartRepository->getItemById(
            $cartItem1->getId()
        );

        $this->assertEntitiesEqual($cartItem1, $cartItem);
    }
}
