<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleDiscount
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    /* @var Product */
    protected $product;

    /* @var CartPriceRule */
    protected $cartPriceRule;

    public function __construct(Product $product = null, $quantity = 1)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    /**
     * @return CartPriceRule
     */
    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }
}
