<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\WarehouseDTOBuilder;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Warehouse implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var Address */
    protected $address;

    public function __construct()
    {
        $this->setCreated();
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

    public function getView()
    {
        return new View\Warehouse($this);
    }

    public function getDTOBuilder()
    {
        return new WarehouseDTOBuilder($this);
    }
}
