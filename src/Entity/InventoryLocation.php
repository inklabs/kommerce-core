<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\InventoryLocationDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryLocation implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    /** @var Warehouse */
    protected $warehouse;

    public function __construct(Warehouse $warehouse, $name, $code)
    {
        $this->setUuid();
        $this->setCreated();
        $this->setWarehouse($warehouse);
        $this->setName($name);
        $this->setCode($code);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
        $metadata->addPropertyConstraint('code', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('warehouse', new Assert\Valid);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setWarehouse(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function getWarehouse()
    {
        return $this->warehouse;
    }

    public function getDTOBuilder()
    {
        return new InventoryLocationDTOBuilder($this);
    }
}
