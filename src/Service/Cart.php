<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Payment\Payment;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use Exception;

class Cart extends Lib\ServiceManager
{
    /** @var Lib\SessionManager */
    protected $sessionManager;
    protected $cartSessionKey = 'newcart';

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

    private function save()
    {
        $this->sessionManager->set($this->cartSessionKey, $this->cart);
    }

    public function clear()
    {
        $this->sessionManager->delete($this->cartSessionKey);
        $this->cart = new Entity\Cart;
    }

    private function reloadProductsFromEntityManager()
    {
        $numberProductsUpdated = 0;
        foreach ($this->cart->getItems() as $cartItem) {
            $product = $this->entityManager->merge($cartItem->getProduct());
            $this->entityManager->refresh($product);
            $cartItem->setProduct($product);

            $newOptionValues = [];
            foreach ($cartItem->getOptionValues() as $optionValue) {
                $optionValue = $this->entityManager->merge($optionValue);
                $this->entityManager->refresh($optionValue);

                $newOptionValues[] = $optionValue;
            }

            if (! empty($newOptionValues)) {
                $cartItem->setOptionValues($newOptionValues);
            }

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
                ->getRepository('kommerce:Coupon')
                ->find($coupon->getId());

            $this->cart->updateCoupon($key, $newCoupon);
            $numberCouponsUpdated++;
        }

        if ($numberCouponsUpdated > 0) {
            $this->save();
        }
    }

    /**
     * @param string $productEncodedId
     * @param int $quantity
     * @param array $optionValueEncodedIds
     * @return int
     * @throws Exception
     */
    public function addItem($productEncodedId, $quantity, $optionValueEncodedIds = null)
    {
        /** @var EntityRepository\Product $productRepository */
        $productRepository = $this->entityManager->getRepository('kommerce:Product');

        $product = $productRepository->find(Lib\BaseConvert::decode($productEncodedId));

        if ($product === null) {
            throw new Exception('Product not found');
        }

        $optionValues = $this->getOptionValues($optionValueEncodedIds);

        $itemId = $this->cart->addItem($product, $quantity, $optionValues);
        $this->save();

        return $itemId;
    }

    /**
     * @param $optionValueEncodedIds
     * @return Entity\Product[]|null
     * @throws Exception
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
                throw new Exception('Option not found');
            }
        }

        return $optionValues;
    }

    public function addCouponByCode($couponCode)
    {
        $coupon = $this->entityManager
            ->getRepository('kommerce:Coupon')
            ->findOneByCode($couponCode);

        if ($coupon === null) {
            throw new Exception('Coupon not found');
        }

        $couponId = $this->cart->addCoupon($coupon);
        $this->save();

        return $couponId;
    }

    /**
     * @param int $key
     * @throws Exception
     */
    public function removeCoupon($key)
    {
        $this->cart->removeCoupon($key);
    }

    /**
     * @return Entity\Coupon[]
     */
    public function getCoupons()
    {
        return $this->cart->getCoupons();
    }

    /**
     * @param int $cartItemId
     * @param int $quantity
     * @throws Exception
     */
    public function updateQuantity($cartItemId, $quantity)
    {
        $item = $this->cart->getItem($cartItemId);
        if ($item === null) {
            throw new Exception('Item not found');
        }

        $item->setQuantity($quantity);
        $this->save();
    }

    /**
     * @param int $cartItemId
     * @throws Exception
     */
    public function deleteItem($cartItemId)
    {
        $this->cart->deleteItem($cartItemId);
        $this->save();
    }

    /**
     * @return View\CartItem[]
     */
    public function getItems()
    {
        $viewCartItems = [];
        foreach ($this->cart->getItems() as $cartItem) {
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
        $cartItem = $this->cart->getItem($id);

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
}
