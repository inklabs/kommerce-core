<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransaction implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var InventoryLocation */
    protected $inventoryLocation;

    /** @var int */
    protected $debitQuantity;

    /** @var int */
    protected $creditQuantity;

    /** @var string */
    protected $memo;

    public function __construct(InventoryLocation $inventoryLocation)
    {
        $this->setCreated();
        $this->inventoryLocation = $inventoryLocation;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('memo', new Assert\NotBlank);
        $metadata->addPropertyConstraint('memo', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('debitQuantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('creditQuantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));


        $metadata->addPropertyConstraint('inventoryLocation', new Assert\Valid);
    }

    /**
     * @param int $quantity
     */
    public function setDebitQuantity($quantity = null)
    {
        $this->debitQuantity = $this->getQuantityOrNull($quantity);
    }

    /**
     * @param int $quantity
     */
    public function setCreditQuantity($quantity = null)
    {
        $this->creditQuantity = $this->getQuantityOrNull($quantity);
    }

    /**
     * @param int $quantity
     * @return int
     */
    protected function getQuantityOrNull($quantity)
    {
        if ($quantity !== null) {
            $quantity = (int) $quantity;
            return $quantity;
        }
        return $quantity;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = (string) $memo;
    }

    public function getInventoryLocation()
    {
        return $this->inventoryLocation;
    }

    public function getDebitQuantity()
    {
        return $this->debitQuantity;
    }

    public function getCreditQuantity()
    {
        return $this->creditQuantity;
    }

    public function getMemo()
    {
        return $this->memo;
    }
}
