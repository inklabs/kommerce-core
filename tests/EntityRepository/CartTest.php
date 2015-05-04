<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class CartTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Coupon',
        'kommerce:Cart',
        'kommerce:CartItem',
        'kommerce:Product',
        'kommerce:User',
    ];

    /** @var CartInterface */
    protected $cartRepository;

    public function setUp()
    {
        $this->cartRepository = $this->repository()->getCart();
    }

    public function setupCart($sessionId = '')
    {
        $product = $this->getDummyProduct();

        $user = $this->getDummyUser();
        $cartItem = $this->getDummyCartItem($product);

        $cart = $this->getDummyCart();
        $cart->setSessionId($sessionId);
        $cart->addCartItem($cartItem);
        $cart->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);

        $this->cartRepository->create($cart);

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCart();

        $this->setCountLogger();

        $cart = $this->cartRepository->find(1);

        $cart->getCartItems()->toArray();
        $cart->getUser()->getCreated();
        $cart->getCoupons()->toArray();

        $this->assertTrue($cart instanceof Entity\Cart);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }

    public function testSave()
    {
        $user1 = $this->getDummyUser(1);
        $user2 = $this->getDummyUser(2);
        $cart = $this->getDummyCart();
        $cart->setUser($user1);

        $this->entityManager->persist($user1);
        $this->entityManager->persist($user2);

        $this->cartRepository->create($cart);

        $cart->setUser($user2);
        $this->assertSame(null, $cart->getUpdated());
        $this->cartRepository->save($cart);
        $this->assertTrue($cart->getUpdated() instanceof \DateTime);
    }

    public function testFindByUser()
    {
        $this->setupCart();

        $this->setCountLogger();

        $cart = $this->cartRepository->findByUser(1);

        $this->assertTrue($cart instanceof Entity\Cart);
    }

    public function testFindBySession()
    {
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';
        $this->setupCart($sessionId);

        $this->setCountLogger();

        $cart = $this->cartRepository->findBySession($sessionId);

        $this->assertTrue($cart instanceof Entity\Cart);
    }
}
