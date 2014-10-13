<?php
namespace inklabs\kommerce\Entity;

class Product
{
    use Accessors;
    use OptionSelector;

    public $id;
    public $sku;
    public $name;
    public $price;
    public $quantity;
    public $product_group_id;
    public $require_inventory;
    public $show_price;
    public $active;
    public $visible;
    public $is_taxable;
    public $shipping;
    public $shipping_weight;
    public $description;
    public $rating;
    public $default_image;
    public $created;
    public $updated;

    public $tags = [];
    public $quantity_discounts = [];

    public function inStock()
    {
        if (($this->require_inventory and $this->quantity > 0) or ( ! $this->require_inventory)) {
            return true;
        } else {
            return false;
        }
    }

    public function getRating()
    {
        return ($this->rating / 100);
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantity_discount)
    {
        $this->quantity_discounts[] = $quantity_discount;
    }

    public function sortQuantityDiscounts()
    {
        // Sort highest to lowest by quantity
        uasort($this->quantity_discounts, create_function('$a, $b', 'return ($a->quantity < $b->quantity);'));
    }
}
