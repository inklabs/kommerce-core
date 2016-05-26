<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\Lib\PricingInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionProduct implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $option_uuid;
    private $product_uuid;

    /** @var int */
    protected $sortOrder;
    /** @var Product */
    protected $product;
    /** @var Option */
    protected $option;

    public function __construct(Option $option, Product $product)
    {
        $this->setUuid();
        $this->setCreated();
        $this->option = $option;
        $this->product = $product;
        $option->addOptionProduct($this);
        $product->addOptionProduct($this);
        $this->setOptionUuid($option->getUuid());
        $this->setProductUuid($product->getUuid());
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
    }

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = (int) $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function getName()
    {
        return $this->product->getName();
    }

    public function getSku()
    {
        return $this->product->getSku();
    }

    public function getShippingWeight()
    {
        return $this->getProduct()->getShippingWeight();
    }

    /**
     * @param PricingInterface $pricing
     * @param int $quantity
     * @return Price
     */
    public function getPrice(PricingInterface $pricing, $quantity = 1)
    {
        return $this->getProduct()->getPrice($pricing, $quantity);
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getDTOBuilder()
    {
        return new OptionProductDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setOptionUuid(UuidInterface $uuid)
    {
        $this->option_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setProductUuid(UuidInterface $uuid)
    {
        $this->product_uuid = $uuid;
    }
}
