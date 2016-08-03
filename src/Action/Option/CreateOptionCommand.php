<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateOptionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionId;

    /** @var OptionDTO */
    private $optionDTO;

    public function __construct(OptionDTO $optionDTO)
    {
        $this->optionId = Uuid::uuid4();
        $this->optionDTO = $optionDTO;
    }

    public function getOptionDTO()
    {
        return $this->optionDTO;
    }

    public function getOptionId()
    {
        return $this->optionId;
    }
}
