<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class CreateProductCommand implements CommandInterface
{
    /** @var ProductDTO */
    private $productDTO;

    public function __construct(ProductDTO $productDTO)
    {
        $this->productDTO = $productDTO;
    }

    public function getProductDTO()
    {
        return $this->productDTO;
    }
}
