<?php
namespace inklabs\kommerce\View\OptionValue;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Product extends AbstractOptionValue implements OptionValueInterface
{
    /** @var View\Product */
    public $product;

    public function __construct(Entity\OptionValue\Product $optionValueCustom)
    {
        parent::__construct($optionValueCustom);

        $this->product = $optionValueCustom->getProduct()->getView()->export();

        return $this;
    }
}
