<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteProductAttributeCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productAttributeId;

    /**
     * @param string $productAttributeId
     */
    public function __construct($productAttributeId)
    {
        $this->productAttributeId = Uuid::fromString($productAttributeId);
    }

    public function getProductAttributeId()
    {
        return $this->productAttributeId;
    }
}
