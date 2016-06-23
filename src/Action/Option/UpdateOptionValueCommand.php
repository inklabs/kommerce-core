<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionValueDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class UpdateOptionValueCommand implements CommandInterface
{
    /** @var OptionValueDTO */
    private $optionValueDTO;

    public function __construct(OptionValueDTO $optionValueDTO)
    {
        $this->optionValueDTO = $optionValueDTO;
    }

    public function getOptionValueDTO()
    {
        return $this->optionValueDTO;
    }
}
