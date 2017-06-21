<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Exception\BadMethodCallException;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ProductQuantityDiscount extends AbstractPromotion
{
    /** @var int */
    protected $quantity;

    /** @var bool */
    protected $flagApplyCatalogPromotions;

    /** @var Product */
    protected $product;

    public function __construct(Product $product, UuidInterface $id = null)
    {
        parent::__construct($id);
        $this->setFlagApplyCatalogPromotions(false);
        $this->product = $product;
        $product->addProductQuantityDiscount($this);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setName(string $name)
    {
        throw new BadMethodCallException('Unable to set name');
    }

    public function getName(): string
    {
        $name = 'Buy ' . $this->getQuantity() . ' or more for ';

        if ($this->type->isExact()) {
            $name .= $this->displayCents($this->getValue()) . ' each';
        } elseif ($this->type->isPercent()) {
            $name .= $this->getValue() . '% off';
        } elseif ($this->type->isFixed()) {
            $name .= $this->displayCents($this->getValue()) . ' off';
        }

        return $name;
    }

    private function displayCents(int $priceInCents): string
    {
        return '$' . number_format(($priceInCents / 100), 2);
    }

    public function getPrice(PricingInterface $pricing): Price
    {
        return $pricing->getPrice(
            $this->product,
            $this->quantity
        );
    }

    public function setFlagApplyCatalogPromotions(bool $flagApplyCatalogPromotions)
    {
        $this->flagApplyCatalogPromotions = $flagApplyCatalogPromotions;
    }

    public function getFlagApplyCatalogPromotions(): bool
    {
        return $this->flagApplyCatalogPromotions;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function isValid(DateTime $date, int $quantity): bool
    {
        return $this->isValidPromotion($date)
            and $this->isQuantityValid($quantity);
    }

    public function isQuantityValid(int $quantity): bool
    {
        if ($quantity >= $this->quantity) {
            return true;
        } else {
            return false;
        }
    }
}
