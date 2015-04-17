<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity\OptionValue\OptionValueInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use Doctrine\Common\Collections\ArrayCollection;

class Regular extends AbstractOptionType implements OptionTypeInterface
{
    public function getView()
    {
        return new View\OptionType\Regular($this);
    }
}
