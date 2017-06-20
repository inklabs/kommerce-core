<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Entity\AttributeChoiceType;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractAttributeCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $attributeId;

    /** @var string */
    protected $name;

    /** @var string */
    private $choiceTypeSlug;

    /** @var int */
    private $sortOrder;

    /** @var null|string */
    protected $description;

    public function __construct(
        string $name,
        string $choiceTypeSlug,
        int $sortOrder,
        ?string $description,
        string $attributeId
    ) {
        $this->attributeId = Uuid::fromString($attributeId);
        $this->name = $name;
        $this->choiceTypeSlug = $choiceTypeSlug;
        $this->sortOrder = $sortOrder;
        $this->description = $description;
    }

    public function getAttributeId(): UuidInterface
    {
        return $this->attributeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChoiceType(): AttributeChoiceType
    {
        return AttributeChoiceType::createBySlug($this->choiceTypeSlug);
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
