<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Entity\TextOptionType;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateTextOptionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $textOptionId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var int */
    private $sortOrder;

    /** @var TextOptionType */
    private $textOptionType;

    public function __construct(string $name, string $description, int $sortOrder, int $textOptionTypeId)
    {
        $this->textOptionId = Uuid::uuid4();
        $this->name = $name;
        $this->description = $description;
        $this->sortOrder = $sortOrder;
        $this->textOptionType = TextOptionType::createById($textOptionTypeId);
    }

    public function getTextOptionId(): UuidInterface
    {
        return $this->textOptionId;
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

    public function getTextOptionType(): TextOptionType
    {
        return $this->textOptionType;
    }
}
