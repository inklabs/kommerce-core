<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionProduct
{
    use Accessor\Created;

    protected $id;

    /* @var Option */
    protected $option;

    /* @var Product */
    protected $product;

    /* @var OrderItem */
    protected $orderItem;

    /* Flattened Columns */
    /* @var string */
    protected $optionName;
    /* @var string */
    protected $productSku;
    /* @var string */
    protected $productName;

    public function __construct(Option $option, Product $product)
    {
        $this->setCreated();

        $this->setOption($option);
        $this->setProduct($product);
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function setOption(Option $option)
    {
        $this->option = $option;

        $this->optionName = $option->getName();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        $this->productSku = $product->getSku();
        $this->productName = $product->getName();
    }

    public function getOptionName()
    {
        return $this->optionName;
    }

    public function getProductSku()
    {
        return $this->productSku;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getOrderItem()
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function getView()
    {
        return new View\OrderItemOptionProduct($this);
    }
}
