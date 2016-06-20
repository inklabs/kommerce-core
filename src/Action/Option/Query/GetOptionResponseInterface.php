<?php
namespace inklabs\kommerce\Action\Option\Query;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;

interface GetOptionResponseInterface
{
    public function setOptionDTOBuilder(OptionDTOBuilder $optionDTOBuilder);
}
