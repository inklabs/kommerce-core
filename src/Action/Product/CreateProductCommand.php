<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    /** @var ProductDTO */
    private $productDTO;

    public function __construct(ProductDTO $productDTO)
    {
        $this->productId = Uuid::uuid4();
        $this->productDTO = $productDTO;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getProductDTO()
    {
        return $this->productDTO;
    }
}
