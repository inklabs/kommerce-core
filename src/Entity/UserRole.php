<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserRole implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 32,
        ]));

        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
