<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateAttributeValueCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $attributeValueId;

    /** @var string */
    protected $name;

    /** @var int */
    private $sortOrder;

    /** @var null|string */
    private $sku;

    /** @var null|string */
    protected $description;

    /**
     * @param string $name
     * @param int $sortOrder
     * @param null|string $sku
     * @param null|string $description
     * @param string $attributeValueId
     */
    public function __construct(
        $name,
        $sortOrder,
        $sku,
        $description,
        $attributeValueId
    ) {
        $this->name = $name;
        $this->sortOrder = $sortOrder;
        $this->sku = $sku;
        $this->description = $description;
        $this->attributeValueId = Uuid::fromString($attributeValueId);
    }

    public function getName()
    {
        return $this->name;
    }
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAttributeValueId()
    {
        return $this->attributeValueId;
    }
}
