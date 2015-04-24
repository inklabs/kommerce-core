<?php
namespace inklabs\kommerce\View\OptionValue;

use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Entity;

abstract class AbstractOptionValue implements OptionValueInterface, View\ViewInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $encodedId;

    /** @var int */
    public $sortOrder;

    public $created;
    public $updated;

    /** @var View\OptionType\AbstractOptionType */
    public $optionType;

    public function __construct(Entity\OptionValue\AbstractOptionValue $optionValue)
    {
        $this->optionValue = $optionValue;

        $this->id        = $optionValue->getId();
        $this->encodedId = Lib\BaseConvert::encode($optionValue->getId());
        $this->created   = $optionValue->getCreated();
        $this->updated   = $optionValue->getUpdated();
    }

    public function export()
    {
        unset($this->optionValue);
        return $this;
    }

    public function withOptionType()
    {
        $optionType = $this->optionValue->getOptionType();
        if ($optionType !== null) {
            $this->optionType = $optionType->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionType();
    }
}
