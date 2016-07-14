<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionType extends AbstractIntegerType
{
    const SELECT = 0;
    const RADIO = 1;
    const CHECKBOX = 2;

    public static function getNameMap()
    {
        return [
            self::SELECT => 'Select',
            self::RADIO => 'Radio',
            self::CHECKBOX => 'Checkbox',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function select()
    {
        return new self(self::SELECT);
    }

    public static function radio()
    {
        return new self(self::RADIO);
    }

    public static function checkbox()
    {
        return new self(self::CHECKBOX);
    }

    public function isSelect()
    {
        return $this->id === self::SELECT;
    }

    public function isRadio()
    {
        return $this->id === self::RADIO;
    }

    public function isCheckbox()
    {
        return $this->id === self::CHECKBOX;
    }
}
