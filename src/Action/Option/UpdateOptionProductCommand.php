<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionProductDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class UpdateOptionProductCommand implements CommandInterface
{
    /** @var OptionProductDTO */
    private $optionProductDTO;

    public function __construct(OptionProductDTO $optionProductDTO)
    {
        $this->optionProductDTO = $optionProductDTO;
    }

    public function getOptionProductDTO()
    {
        return $this->optionProductDTO;
    }
}
