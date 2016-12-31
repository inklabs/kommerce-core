<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractAttributeCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $attributeId;

    /** @var string */
    protected $name;

    /** @var int */
    private $sortOrder;

    /** @var null|string */
    protected $description;

    /**
     * @param string $name
     * @param int $sortOrder
     * @param null|string $description
     * @param string $attributeId
     */
    public function __construct(
        $name,
        $sortOrder,
        $description,
        $attributeId
    ) {
        $this->attributeId = Uuid::fromString($attributeId);
        $this->name = $name;
        $this->sortOrder = $sortOrder;
        $this->description = $description;
    }

    public function getAttributeId()
    {
        return $this->attributeId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
