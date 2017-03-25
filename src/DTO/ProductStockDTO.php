<?php
namespace inklabs\kommerce\DTO;

use inklabs\kommerce\EntityDTO\ProductDTO;

class ProductStockDTO
{
    /** @var ProductDTO */
    private $productDTO;

    /** @var int */
    private $quantity;

    /**
     * @param ProductDTO $productDTO
     * @param int $quantity
     */
    public function __construct(ProductDTO $productDTO, $quantity)
    {
        $this->productDTO = $productDTO;
        $this->quantity = $quantity;
    }

    public function getProductDTO()
    {
        return $this->productDTO;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
