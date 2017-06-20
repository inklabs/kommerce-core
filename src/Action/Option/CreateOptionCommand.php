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

    public function __construct(
        string $name,
        string $description,
        int $sortOrder,
        string $optionTypeSlug
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->sortOrder = $sortOrder;
        $this->optionTypeSlug = $optionTypeSlug;
        $this->optionId = Uuid::uuid4();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getOptionType(): OptionType
    {
        return OptionType::createBySlug($this->optionTypeSlug);
    }

    public function getOptionId(): UuidInterface
    {
        return $this->optionId;
    }
}
