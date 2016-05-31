<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\EntityDTO\CartItemTextOptionValueDTO;

class CartItemTextOptionValueDTOBuilder
{
    /** @var CartItemTextOptionValue */
    protected $cartItemTextOptionValue;

    /** @var CartItemTextOptionValueDTO */
    protected $cartItemTextOptionValueDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CartItemTextOptionValue $cartItemTextOptionValue,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->cartItemTextOptionValue = $cartItemTextOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->cartItemTextOptionValueDTO = new CartItemTextOptionValueDTO;
        $this->cartItemTextOptionValueDTO->id              = $this->cartItemTextOptionValue->getId();
        $this->cartItemTextOptionValueDTO->created         = $this->cartItemTextOptionValue->getCreated();
        $this->cartItemTextOptionValueDTO->updated         = $this->cartItemTextOptionValue->getUpdated();
        $this->cartItemTextOptionValueDTO->textOptionValue = $this->cartItemTextOptionValue->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->cartItemTextOptionValueDTO->textOption = $this->dtoBuilderFactory
            ->getTextOptionDTOBuilder($this->cartItemTextOptionValue->getTextOption())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }

    public function build()
    {
        return $this->cartItemTextOptionValueDTO;
    }
}
