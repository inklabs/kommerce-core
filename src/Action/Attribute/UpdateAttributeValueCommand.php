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

    public function __construct(
        string $name,
        int $sortOrder,
        ?string $sku,
        ?string $description,
        string $attributeValueId
    ) {
        $this->name = $name;
        $this->sortOrder = $sortOrder;
        $this->sku = $sku;
        $this->description = $description;
        $this->attributeValueId = Uuid::fromString($attributeValueId);
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAttributeValueId(): UuidInterface
    {
        return $this->attributeValueId;
    }
}
