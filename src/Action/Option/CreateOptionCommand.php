<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class CreateOptionCommand implements CommandInterface
{
    /** @var OptionDTO */
    private $optionDTO;

    public function __construct(OptionDTO $optionDTO)
    {
        $this->optionDTO = $optionDTO;
    }

    public function getOptionDTO()
    {
        return $this->optionDTO;
    }
}
