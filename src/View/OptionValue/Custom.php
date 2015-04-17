<?php
namespace inklabs\kommerce\View\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Custom extends AbstractOptionValue implements OptionValueInterface
{
    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var View\Price */
    public $price;

    /** @var int */
    public $shippingWeight;

    public function __construct(Entity\OptionValue\Custom $optionValueCustom)
    {
        parent::__construct($optionValueCustom);

        return $this;
    }
}
