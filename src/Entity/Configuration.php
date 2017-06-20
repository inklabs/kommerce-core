<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
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

    public function __construct(string $key, string $name, string $value, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->key = (string) $key;
        $this->name = (string) $name;
        $this->value = (string) $value;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
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

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
