<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPromotion implements IdEntityInterface
{
    use TimeTrait, IdTrait, PromotionRedemptionTrait, PromotionStartEndDateTrait;

    /** @var string|null */
    protected $name;

    /** @var PromotionType */
    protected $type;

    /** @var int|null */
    protected $value;

    /** @var boolean */
    protected $reducesTaxSubtotal;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->setType(PromotionType::fixed());
        $this->setRedemptions(0);
        $this->setReducesTaxSubtotal(true);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Valid);

        $metadata->addPropertyConstraint('value', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        self::loadPromotionRedemptionValidatorMetadata($metadata);
        self::loadPromotionStartEndDateValidatorMetadata($metadata);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setType(PromotionType $type)
    {
        $this->type = $type;
    }

    public function getType(): PromotionType
    {
        return $this->type;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setReducesTaxSubtotal(bool $reducesTaxSubtotal)
    {
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
    }

    public function getReducesTaxSubtotal(): bool
    {
        return $this->reducesTaxSubtotal;
    }

    public function isValidPromotion(DateTime $date)
    {
        return $this->isDateValid($date)
            and $this->isRedemptionCountValid();
    }

    public function getUnitPrice(int $unitPrice): int
    {
        $returnValue = 0;

        if ($this->type->isFixed()) {
            $returnValue = $unitPrice - $this->value;
        } elseif ($this->type->isPercent()) {
            $returnValue = (int) $unitPrice - ($unitPrice * ($this->value / 100));
        } elseif ($this->type->isExact()) {
            $returnValue = $this->value;
        }

        return $returnValue;
    }
}
