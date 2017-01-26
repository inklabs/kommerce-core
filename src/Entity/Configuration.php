<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Configuration implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $key;

    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /**
     * @param string $key
     * @param string $name
     * @param string $value
     * @param null $id
     */
    public function __construct($key, $name, $value, $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->key = (string) $key;
        $this->name = (string) $name;
        $this->value = (string) $value;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('key', new Assert\NotBlank);
        $metadata->addPropertyConstraint('key', new Assert\Length([
            'max' => 30,
        ]));

        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 50,
        ]));

        $metadata->addPropertyConstraint('value', new Assert\NotBlank);
        $metadata->addPropertyConstraint('value', new Assert\Length([
            'max' => 255,
        ]));
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = (string) $key;
    }

    public function getKey()
    {
        return $this->key;
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
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = (string) $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
