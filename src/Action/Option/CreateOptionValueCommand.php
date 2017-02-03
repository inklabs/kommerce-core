<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionValueDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateOptionValueCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionValueId;

    /** @var UuidInterface */
    private $optionId;

    /** @var OptionValueDTO */
    private $optionValueDTO;

    /**
     * @param string $optionId
     * @param OptionValueDTO $optionValueDTO
     */
    public function __construct($optionId, OptionValueDTO $optionValueDTO)
    {
        $this->optionValueId = Uuid::uuid4();
        $this->optionId = Uuid::fromString($optionId);
        $this->optionValueDTO = $optionValueDTO;
    }

    public function getOptionId()
    {
        return $this->optionId;
    }

    public function getOptionValueDTO()
    {
        return $this->optionValueDTO;
    }

    public function getOptionValueId()
    {
        return $this->optionValueId;
    }
}
