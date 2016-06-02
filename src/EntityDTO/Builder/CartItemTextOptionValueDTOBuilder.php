<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\EntityDTO\CartItemTextOptionValueDTO;

class CartItemTextOptionValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var CartItemTextOptionValue */
    protected $entity;

    /** @var CartItemTextOptionValueDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        CartItemTextOptionValue $cartItemTextOptionValue,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $cartItemTextOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartItemTextOptionValueDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->textOptionValue = $this->entity->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->entityDTO->textOption = $this->dtoBuilderFactory
            ->getTextOptionDTOBuilder($this->entity->getTextOption())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
