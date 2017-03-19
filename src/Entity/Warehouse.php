<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Warehouse implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var Address */
    protected $address;

    /** @var InventoryLocation[] */
    protected $inventoryLocations;

    /**
     * @param string $name
     * @param Address $address
     * @param UuidInterface $id
     */
    public function __construct($name, Address $address, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->name = (string) $name;
        $this->address = $address;
        $this->inventoryLocations = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('address', new Assert\Valid);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return InventoryLocation[]
     */
    public function getInventoryLocations()
    {
        return $this->inventoryLocations;
    }

    public function addInventoryLocation(InventoryLocation $inventoryLocation)
    {
        $this->inventoryLocations->add($inventoryLocation);
    }
}
