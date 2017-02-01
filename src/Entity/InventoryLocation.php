<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryLocation implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    /** @var Warehouse */
    protected $warehouse;

    public function __construct(Warehouse $warehouse, $name, $code)
    {
        $this->setId();
        $this->setCreated();
        $this->warehouse = $warehouse;
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

    public function getWarehouse()
    {
        return $this->warehouse;
    }
}
