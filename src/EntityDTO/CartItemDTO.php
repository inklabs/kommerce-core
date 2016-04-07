<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $fullSku;

    /** @var int */
    public $quantity;

    /** @var int */
    public $shippingWeight;

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
