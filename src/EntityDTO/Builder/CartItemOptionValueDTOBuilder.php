<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\EntityDTO\CartItemOptionValueDTO;

class CartItemOptionValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var CartItemOptionValue */
    private $entity;

    /** @var CartItemOptionValueDTO */
    private $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(CartItemOptionValue $cartItemOptionValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $cartItemOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartItemOptionValueDTO;
        $this->setId();
        $this->setTime();

        $this->entityDTO->optionValue = $this->dtoBuilderFactory
            ->getOptionValueDTOBuilder($this->entity->getOptionValue())
            ->withAllData()
            ->build();
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
