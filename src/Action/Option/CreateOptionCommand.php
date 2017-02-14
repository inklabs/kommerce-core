<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateOptionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var int */
    private $sortOrder;

    /** @var string */
    private $optionTypeSlug;

    /**
     * @param string $name
     * @param string $description
     * @param int $sortOrder
     * @param string $optionTypeSlug
     */
    public function __construct(
        $name,
        $description,
        $sortOrder,
        $optionTypeSlug
    ) {
        $this->name = (string) $name;
        $this->description = (string) $description;
        $this->sortOrder = (int) $sortOrder;
        $this->optionTypeSlug = (string) $optionTypeSlug;
        $this->optionId = Uuid::uuid4();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return OptionType
     */
    public function getOptionType()
    {
        return OptionType::createBySlug($this->optionTypeSlug);
    }

    public function getOptionId()
    {
        return $this->optionId;
    }
}
