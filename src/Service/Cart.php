<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Payment\Payment;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class Cart extends AbstractService
{
    /** @var EntityRepository\CouponInterface */
    protected $couponRepository;

    /** @var EntityRepository\CartInterface */
    protected $cartRepository;

    /** @var Entity\Cart */
    protected $cart;

    /** @var Entity\Shipping\Rate */
    protected $shippingRate;

    /** @var Entity\TaxRate */
    protected $taxRate;

    /** @var Pricing */
    protected $pricing;

    /** @var Entity\User */
    protected $user;

    public function __construct(
        EntityRepository\CartInterface $cartRepository,
        EntityRepository\CouponInterface $couponRepository,
        Pricing $pricing
    ) {
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
        $this->pricing = $pricing;
    }

    public function find($id)
    {
        $cart = $this->cartRepository->find($id);

        if ($cart === null) {
            return null;
        }

        return $cart->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param string $productEncodedId
     * @param int $quantity
     * @param array $optionValueEncodedIds
     * @return int
     * @throws \Exception
     */
    public function addItem($productEncodedId, $quantity, $optionValueEncodedIds = null)
    {
        /** @var EntityRepository\Product $productRepository */
        $productRepository = $this->entityManager->getRepository('kommerce:Product');

        $product = $productRepository->find(Lib\BaseConvert::decode($productEncodedId));

        if ($product === null) {
            throw new \Exception('Product not found');
        }

        $optionValues = $this->getOptionValues($optionValueEncodedIds);

        $itemId = $this->cart->addCartItem($product, $quantity, $optionValues);
        $this->save();

        return $itemId;
    }

    /**
     * @param $optionValueEncodedIds
     * @return Entity\Product[]|null
     * @throws \Exception
     */
    private function getOptionValues($optionValueEncodedIds)
    {
        /** @var EntityRepository\OptionValue $optionValueRepository */
        $optionValueRepository = $this->entityManager->getRepository('kommerce:OptionValue\AbstractOptionValue');

        $optionValues = null;
        if ($optionValueEncodedIds !== null) {
            $optionValueIds = [];
            foreach ($optionValueEncodedIds as $optionEncodedId => $optionValueEncodedId) {
                $optionValueIds[] = Lib\BaseConvert::decode((string) $optionValueEncodedId);
            }

            $optionValues = $optionValueRepository->getAllOptionValuesByIds($optionValueIds);

            if (count($optionValues) !== count($optionValueEncodedIds)) {
                throw new \Exception('Option not found');
            }
        }

        return $optionValues;
    }

    /**
     * @param int $cartId
     * @param string $couponCode
     * @return int
     */
    public function addCouponByCode($cartId, $couponCode)
    {
        $cart = $this->getCartAndThrowExceptionIfNotFound($cartId);
        $coupon = $this->couponRepository->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new \LogicException('Coupon not found');
        }

        $couponIndex = $cart->addCoupon($coupon);

        $this->cartRepository->save($cart);

        return $couponIndex;
    }

    /**
     * @param int $cartId
     * @param int $couponIndex
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function removeCoupon($cartId, $couponIndex)
    {
        $cart = $this->getCartAndThrowExceptionIfNotFound($cartId);

        $cart->removeCoupon($couponIndex);

        $this->cartRepository->save($cart);
    }

    /**
     * @param int $cartId
     * @return Entity\Coupon[]
     */
    public function getCoupons($cartId)
    {
        $cart = $this->getCartAndThrowExceptionIfNotFound($cartId);
        return $cart->getCoupons();
    }

    /**
     * @param int $cartItemId
     * @param int $quantity
     * @throws \Exception
     */
    public function updateQuantity($cartItemId, $quantity)
    {
        $item = $this->cart->getCartItem($cartItemId);
        if ($item === null) {
            throw new \Exception('Item not found');
        }

        $item->setQuantity($quantity);
        $this->save();
    }

    /**
     * @param int $cartItemId
     * @throws \Exception
     */
    public function deleteItem($cartItemId)
    {
        $this->cart->deleteCartItem($cartItemId);
        $this->save();
    }

    /**
     * @return View\CartItem[]
     */
    public function getItems()
    {
        $viewCartItems = [];
        foreach ($this->cart->getCartItems() as $cartItem) {
            $viewCartItems[] = $cartItem->getView()
                ->withAllData($this->pricing)
                ->export();
        }

        return $viewCartItems;
    }

    /**
     * @return View\Product[]
     */
    public function getProducts()
    {
        $products = [];
        foreach ($this->getItems() as $item) {
            $products[] = $item->product;
        }
        return $products;
    }

    /**
     * @return View\CartItem|null
     */
    public function getItem($id)
    {
        $cartItem = $this->cart->getCartItem($id);

        if ($cartItem === null) {
            return null;
        }

        return $cartItem->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    public function getShippingWeight()
    {
        return $this->cart->getShippingWeight();
    }

    public function getShippingWeightInPounds()
    {
        return (int) ceil($this->cart->getShippingWeight() / 16);
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

    public function createOrder(Payment $payment, OrderAddress $shippingAddress, OrderAddress $billingAddress = null)
    {
        if ($billingAddress === null) {
            $billingAddress = clone $shippingAddress;
        }

        $order = $this->cart->getOrder($this->pricing, $this->shippingRate, $this->taxRate);
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->addPayment($payment);

        foreach ($this->cart->getCoupons() as $coupon) {
            $order->addCoupon($coupon);
        }

        if ($this->user !== null) {
            $order->setUser($this->user);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function getView()
    {
        return $this->cart->getView()
            ->withAllData($this->pricing, $this->shippingRate, $this->taxRate)
            ->export();
    }

    public function setUser(Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $cartId
     * @return Entity\Cart
     */
    protected function getCartAndThrowExceptionIfNotFound($cartId)
    {
        $cart = $this->cartRepository->find($cartId);

        if ($cart === null) {
            throw new \LogicException('Cart not found');
        }

        return $cart;
    }
}
