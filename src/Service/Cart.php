<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class Cart extends \inklabs\kommerce\Lib\EntityManager
{
    protected $sessionManager;
    protected $cartSessionKey = 'newcart';
    protected $cart;

    private $pricing;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        \inklabs\kommerce\Service\Pricing $pricing,
        \inklabs\kommerce\Lib\SessionManager $sessionManager
    ) {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
        $this->sessionManager = $sessionManager;

        $this->load();
        if (! ($this->cart instanceof Entity\Cart)) {
            $this->cart = new Entity\Cart;
        }
    }

    private function load()
    {
        $this->cart = $this->sessionManager->get($this->cartSessionKey);
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

        $itemId = $this->cart->addItem($product, $quantity);
        $this->save();

        return $itemId;
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $item = $this->cart->getItem($cartItemId);
        if ($item === null) {
            throw new \Exception('Item not found');
        }

        $item->setQuantity($quantity);
        $this->save();
    }

    public function deleteItem($cartItemId)
    {
        $item = $this->getItem($cartItemId);
        if ($item === null) {
            throw new \Exception('Item not found');
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
        return $this->cart->getTotal($this->pricing);
    }

    public function getView()
    {
        return Entity\View\Cart::factory($this->cart)
            ->withAllData($this->pricing)
            ->export();
    }
}
