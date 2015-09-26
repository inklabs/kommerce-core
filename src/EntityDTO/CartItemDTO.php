<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemDTO
{
    public $id;
    public $encodedId;
    public $fullSku;
    public $quantity;
    public $shippingWeight;
    public $created;
    public $updated;

    /** @var ProductDTO */
    public $product;

    /** @var CartItemOptionProductDTO[] */
    public $cartItemOptionProducts = [];

    /** @var CartItemOptionValueDTO[] */
    public $cartItemOptionValues = [];

    /** @var CartItemTextOptionValueDTO[] */
    public $cartItemTextOptionValues = [];

    /** @var PriceDTO */
    public $price;
}
