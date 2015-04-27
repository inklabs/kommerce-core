<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CartItemOptionValue implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var OptionValue */
    public $optionValue;

    public function __construct(Entity\CartItemOptionValue $cartItemOptionValue)
    {
        $this->id      = $cartItemOptionValue->getId();
        $this->created = $cartItemOptionValue->getCreated();
        $this->updated = $cartItemOptionValue->getUpdated();

        $this->optionValue = $cartItemOptionValue->getOptionValue()->getView()
            ->export();
    }

    public function export()
    {
        return $this;
    }
}
