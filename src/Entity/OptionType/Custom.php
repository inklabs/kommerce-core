<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Custom extends AbstractOptionType implements OptionTypeInterface
{
    public function getView()
    {
        return new View\OptionType\Custom($this);
    }
}
