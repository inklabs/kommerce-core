<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateProductAttributeCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productAttributeId;

    /** @var UuidInterface */
    private $attributeValueId;

    /** @var UuidInterface */
    private $productId;

    /**
     * @param string $attributeValueId
     * @param string $productId
     */
    public function __construct($attributeValueId, $productId)
    {
        $this->productAttributeId = Uuid::uuid4();
        $this->attributeValueId = Uuid::fromString($attributeValueId);
        $this->productId = Uuid::fromString($productId);
    }

    public function getAttributeValueId()
    {
        return $this->attributeValueId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getProductAttributeId()
    {
        return $this->productAttributeId;
    }
}
