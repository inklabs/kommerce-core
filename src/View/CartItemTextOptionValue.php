<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CartItemTextOptionValue implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var string */
    public $textOptionValue;

    /** @var TextOption */
    public $textOption;

    public function __construct(Entity\CartItemTextOptionValue $cartItemTextOptionValue)
    {
        $this->cartItemTextOptionValue = $cartItemTextOptionValue;

        $this->id              = $cartItemTextOptionValue->getId();
        $this->created         = $cartItemTextOptionValue->getCreated();
        $this->updated         = $cartItemTextOptionValue->getUpdated();
        $this->textOptionValue = $cartItemTextOptionValue->getTextOptionValue();
    }

    public function export()
    {
        unset($this->cartItemTextOptionValue);
        return $this;
    }

    public function withTextOption()
    {
        $this->textOption = $this->cartItemTextOptionValue->getTextOption()->getView()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }
}
