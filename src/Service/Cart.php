<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use Exception;

class Cart extends Lib\EntityManager
{
    protected $sessionManager;
    protected $cartSessionKey = 'newcart';
    protected $cart;
    protected $shippingRate;
    protected $taxRate;

    private $pricing;

    public function __construct(EntityManager $entityManager, Pricing $pricing, Lib\SessionManager $sessionManager)
    {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
        $this->sessionManager = $sessionManager;

        $this->load();
    }

    private function load()
    {
        $this->cart = $this->sessionManager->get($this->cartSessionKey);

        if (! ($this->cart instanceof Entity\Cart)) {
            $this->cart = new Entity\Cart;
        }

        $this->reloadProductsFromEntityManager();
        $this->reloadCouponsFromEntityManager();
    }

    private function reloadProductsFromEntityManager()
    {
        $numberProductsUpdated = 0;
        foreach ($this->cart->getItems() as $cartItem) {
            $product = $this->entityManager
                ->getRepository('inklabs\kommerce\Entity\Product')
                ->find($cartItem->getProduct()->getId());

            $cartItem->setProduct($product);
            $numberProductsUpdated++;
        }

        if ($numberProductsUpdated > 0) {
            $this->save();
        }
    }

    private function reloadCouponsFromEntityManager()
    {
        $numberCouponsUpdated = 0;
        foreach ($this->cart->getCoupons() as $key => $coupon) {
            $newCoupon = $this->entityManager
                ->getRepository('inklabs\kommerce\Entity\Coupon')
                ->find($coupon->getId());

            $this->cart->updateCoupon($key, $newCoupon);
            $numberCouponsUpdated++;
        }

        if ($numberCouponsUpdated > 0) {
            $this->save();
        }
    }

    private function save()
    {
        $this->sessionManager->set($this->cartSessionKey, $this->cart);
    }

    public function addItem(Entity\View\Product $viewProduct, $quantity)
    {
        $product = $this->entityManager
            ->getRepository('inklabs\kommerce\Entity\Product')
            ->find($viewProduct->id);

        if ($product === null) {
            throw new Exception('Product not found');
        }

        $itemId = $this->cart->addItem($product, $quantity);
        $this->save();

        return $itemId;
    }

    public function addCoupon($couponCode)
    {
        $coupon = $this->entityManager
            ->getRepository('inklabs\kommerce\Entity\Coupon')
            ->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new Exception('Coupon not found');
        }

        $this->cart->addCoupon($coupon);
    }

    public function removeCoupon($key)
    {
        $this->cart->removeCoupon($key);
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $item = $this->cart->getItem($cartItemId);
        if ($item === null) {
            throw new Exception('Item not found');
        }

        $item->setQuantity($quantity);
        $this->save();
    }

    public function deleteItem($cartItemId)
    {
        $item = $this->getItem($cartItemId);
        if ($item === null) {
            throw new Exception('Item not found');
        }

        $this->cart->deleteItem($cartItemId);
        $this->save();
    }

    public function getItems()
    {
        $viewCartItems = [];
        foreach ($this->cart->getItems() as $cartItem) {
            $viewCartItems[] = Entity\View\CartItem::factory($cartItem)
                ->withAllData($this->pricing)
                ->export();
        }

        return $viewCartItems;
    }

    public function getProducts()
    {
        $products = [];
        foreach ($this->getItems() as $item) {
            $products[] = $item->product;
        }
        return $products;
    }

    public function getItem($id)
    {
        $cartItem = $this->cart->getItem($id);

        if ($cartItem === null) {
            return null;
        }

        return Entity\View\CartItem::factory($cartItem)
            ->withAllData($this->pricing)
            ->export();
    }

    public function getShippingWeight()
    {
        return $this->cart->getShippingWeight();
    }

    public function getShippingWeightInPounds()
    {
        return ceil($this->cart->getShippingWeight() / 16);
    }

    public function totalItems()
    {
        return $this->cart->totalItems();
    }

    public function totalQuantity()
    {
        return $this->cart->totalQuantity();
    }

    public function getTotal()
    {
        return $this->cart->getTotal($this->pricing, $this->shippingRate, $this->taxRate);
    }

    public function setShippingRate(Entity\Shipping\Rate $shippingRate)
    {
        $this->shippingRate = $shippingRate;
        $this->save();
    }

    public function setTaxRate(Entity\TaxRate $taxRate)
    {
        $this->taxRate = $taxRate;
        $this->save();
    }

    public function getView()
    {
        return Entity\View\Cart::factory($this->cart)
            ->withAllData($this->pricing, $this->shippingRate, $this->taxRate)
            ->export();
    }
}
