<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Entity\OptionType\OptionTypeInterface;
use inklabs\kommerce\Entity;

abstract class AbstractOptionValue implements OptionValueInterface
{
    use Entity\Accessor\Time, Entity\Accessor\Id;

    /** @var int */
    protected $sortOrder;

    /** @var OptionTypeInterface */
    protected $optionType;

    public function __construct()
    {
        $this->setCreated();
        $this->sortOrder = 0;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setOptionType(OptionTypeInterface $optionType)
    {
        $this->optionType = $optionType;
    }

    public function getOptionType()
    {
        return $this->optionType;
    }
}
