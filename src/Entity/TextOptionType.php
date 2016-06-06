<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method static TextOptionType createById($id)
 */
class TextOptionType extends AbstractIntegerType
{
    const TEXT     = 3;
    const TEXTAREA = 4;
    const FILE     = 5;
    const DATE     = 6;
    const TIME     = 7;
    const DATETIME = 8;

    public static function getNameMap()
    {
        return [
            self::TEXT => 'Text',
            self::TEXTAREA => 'Textarea',
            self::FILE => 'File',
            self::DATE => 'Date',
            self::TIME => 'Time',
            self::DATETIME => 'DateTime',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function text()
    {
        return new self(self::TEXT);
    }

    public static function textarea()
    {
        return new self(self::TEXTAREA);
    }

    public static function file()
    {
        return new self(self::FILE);
    }

    public static function date()
    {
        return new self(self::DATE);
    }

    public static function time()
    {
        return new self(self::TIME);
    }

    public static function dateTime()
    {
        return new self(self::DATETIME);
    }

    public function isText()
    {
        return $this->id === self::TEXT;
    }

    public function isTextarea()
    {
        return $this->id === self::TEXTAREA;
    }

    public function isFile()
    {
        return $this->id === self::FILE;
    }

    public function isDate()
    {
        return $this->id === self::DATE;
    }
    public function isTime()
    {
        return $this->id === self::TIME;
    }
    public function isDateTime()
    {
        return $this->id === self::DATETIME;
    }
}
