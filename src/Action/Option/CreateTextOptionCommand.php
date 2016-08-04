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

    /**
     * @param string $name
     * @param string $description
     * @param int $sortOrder
     * @param int $textOptionTypeId
     */
    public function __construct($name, $description, $sortOrder, $textOptionTypeId)
    {
        $this->textOptionId = Uuid::uuid4();
        $this->name = (string)$name;
        $this->description = (string)$description;
        $this->sortOrder = (int)$sortOrder;
        $this->textOptionType = TextOptionType::createById($textOptionTypeId);
    }

    public function getTextOptionId()
    {
        return $this->textOptionId;
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
     * @return TextOptionType
     */
    public function getTextOptionType()
    {
        return $this->textOptionType;
    }
}
