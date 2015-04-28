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

    /**
     * @return Cart
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Cart');
    }

    public function setupCart()
    {
        $product = $this->getDummyProduct();

        $user = $this->getDummyUser();
        $cartItem = $this->getDummyCartItem($product);

        $cart = $this->getDummyCart();
        $cart->addCartItem($cartItem);
        $cart->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCart();

        $this->setCountLogger();

        $cart = $this->getRepository()
            ->find(1);

        $cart->getCartItems()->toArray();
        $cart->getUser()->getCreated();
        $cart->getCoupons()->toArray();

        $this->assertTrue($cart instanceof Entity\Cart);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}
