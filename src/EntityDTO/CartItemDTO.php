<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $fullSku;
    public $quantity;
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
