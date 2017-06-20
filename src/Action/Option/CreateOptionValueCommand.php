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

    public function __construct(string $optionId, OptionValueDTO $optionValueDTO)
    {
        $this->optionValueId = Uuid::uuid4();
        $this->optionId = Uuid::fromString($optionId);
        $this->optionValueDTO = $optionValueDTO;
    }

    public function getOptionId(): UuidInterface
    {
        return $this->optionId;
    }

    public function getOptionValueDTO(): OptionValueDTO
    {
        return $this->optionValueDTO;
    }

    public function getOptionValueId(): UuidInterface
    {
        return $this->optionValueId;
    }
}
