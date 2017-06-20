<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class AttributeChoiceType extends AbstractIntegerType
{
    const SELECT = 0;
    const IMAGE_LINK = 1;

    public static function getNameMap(): array
    {
        return [
            self::SELECT => 'Select',
            self::IMAGE_LINK => 'Image Link',
        ];
    }

    public static function getSlugMap(): array
    {
        return [
            self::SELECT => 'select',
            self::IMAGE_LINK => 'image-link',
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

    public static function imageLink()
    {
        return new self(self::IMAGE_LINK);
    }

    public function isSelect()
    {
        return $this->id === self::SELECT;
    }

    public function isImageLink()
    {
        return $this->id === self::IMAGE_LINK;
    }
}
