<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\EntityDTO\OptionValueDTO;
use inklabs\kommerce\Lib\UuidInterface;

class OptionValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OptionValue */
    protected $entity;

    /** @var OptionValueDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(OptionValue $optionValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $optionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new OptionValueDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->sku            = $this->entity->getSku();
        $this->entityDTO->name           = $this->entity->getName();
        $this->entityDTO->unitPrice      = $this->entity->getUnitPrice();
        $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();
        $this->entityDTO->sortOrder      = $this->entity->getSortOrder();
    }

    public static function createFromDTO(Option $option, OptionValueDTO $optionValueDTO, UuidInterface $optionValueId)
    {
        $optionValue = new OptionValue($option, $optionValueId);
        self::setFromDTO($optionValue, $optionValueDTO);
        return $optionValue;
    }

    public static function setFromDTO(OptionValue & $optionValue, OptionValueDTO $optionValueDTO)
    {
        $optionValue->setSku($optionValueDTO->sku);
        $optionValue->setName($optionValueDTO->name);
        $optionValue->setUnitPrice($optionValueDTO->unitPrice);
        $optionValue->setShippingWeight($optionValueDTO->shippingWeight);
        $optionValue->setSortOrder($optionValueDTO->sortOrder);
    }

    /**
     * @return static
     */
    public function withOption()
    {
        $this->entityDTO->option = $this->dtoBuilderFactory
            ->getOptionDTOBuilder($this->entity->getOption())
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withPrice()
    {
        $this->entityDTO->price = $this->dtoBuilderFactory
            ->getPriceDTOBuilder($this->entity->getPrice())
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withOption()
            ->withPrice();
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
