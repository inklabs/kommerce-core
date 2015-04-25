<?php
namespace inklabs\kommerce\Entity\OptionType;

use inklabs\kommerce\Entity\OptionValue\OptionValueInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

interface OptionTypeInterface
{
    public function getTypeMapping();

    /**
     * @return string
     */
    public function getName();

    public function addOptionValue(OptionValueInterface $optionValue);

    /**
     * @return OptionValueInterface[]
     */
    public function getOptionValues();

    public function addTag(Entity\Tag $tag);

    /**
     * @return View\ViewInterface
     */
    public function getView();
}
