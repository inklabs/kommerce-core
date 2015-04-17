<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Entity\OptionType\OptionTypeInterface;
use inklabs\kommerce\Service;

interface OptionValueInterface
{
    /** @return OptionTypeInterface */
    public function getOptionType();

    /** @return string */
    public function getName();

    /** @return string */
    public function getSku();

    /** @return int */
    public function getShippingWeight();

    public function setOptionType(OptionTypeInterface $optionType);

    /** @param int $sortOrder */
    public function setSortOrder($sortOrder);

    /** @return int */
    public function getSortOrder();

    public function getPrice(Service\Pricing $pricing);

    public function getView();
}
