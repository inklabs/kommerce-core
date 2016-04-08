<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
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
        $cart = $this->dummyData->getCart();
        $this->cartRepository->create($cart);
        $this->assertSame(1, $cart->getId());

        $cart->setSessionId('sessionidXXX');
        $this->assertSame(null, $cart->getUpdated());

        $this->cartRepository->update($cart);
        $this->assertTrue($cart->getUpdated() instanceof DateTime);

        $this->entityManager->clear();
        $cart = $this->cartRepository->findOneById($cart->getId());
        $this->assertSame('10.0.0.1', $cart->getIp4());

        $this->cartRepository->delete($cart);
        $this->assertSame(null, $cart->getId());
    }

    public function testFindOneById()
    {
        $this->setupCart();

        $this->setCountLogger();

        $cart = $this->cartRepository->findOneById(1);

        $cart->getCartItems()->toArray();
        $cart->getUser()->getCreated();
        $cart->getCoupons()->toArray();
        $cart->getTaxRate()->getCreated();

        $this->assertTrue($cart instanceof Cart);
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testSave()
    {
        $user1 = $this->dummyData->getUser(1);
        $user2 = $this->dummyData->getUser(2);
        $cart = $this->dummyData->getCart();
        $cart->setUser($user1);

        $this->entityManager->persist($user1);
        $this->entityManager->persist($user2);

        $this->cartRepository->create($cart);

        $cart->setUser($user2);
        $this->assertSame(null, $cart->getUpdated());
        $this->cartRepository->update($cart);
        $this->assertTrue($cart->getUpdated() instanceof DateTime);
    }

    public function testRemove()
    {
        $cart = $this->dummyData->getCart();

        $this->cartRepository->create($cart);

        $this->assertSame(1, $cart->getId());
        $this->cartRepository->delete($cart);
        $this->assertSame(null, $cart->getId());
    }

    public function testFindByUser()
    {
        $this->setupCart();

        $this->setCountLogger();

        $cart = $this->cartRepository->findOneByUser(1);

        $this->assertTrue($cart instanceof Cart);
    }

    public function testFindBySession()
    {
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';
        $this->setupCart($sessionId);

        $this->setCountLogger();

        $cart = $this->cartRepository->findOneBySession($sessionId);

        $this->assertTrue($cart instanceof Cart);
    }
}
