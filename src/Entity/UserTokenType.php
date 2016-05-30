<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\UserTokenTypeDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method static UserTokenType createById($id)
 */
class UserTokenType extends AbstractIntegerType
{
    const INTERNAL = 0;
    const GOOGLE   = 1;
    const FACEBOOK = 2;
    const TWITTER  = 3;
    const YAHOO    = 4;

    public static function getNameMap()
    {
        return [
            self::INTERNAL => 'Internal',
            self::GOOGLE => 'Google',
            self::FACEBOOK => 'Facebook',
            self::TWITTER => 'Twitter',
            self::YAHOO => 'Yahoo',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function internal()
    {
        return new self(self::INTERNAL);
    }

    public static function google()
    {
        return new self(self::GOOGLE);
    }

    public static function facebook()
    {
        return new self(self::FACEBOOK);
    }

    public static function twitter()
    {
        return new self(self::TWITTER);
    }

    public static function yahoo()
    {
        return new self(self::YAHOO);
    }

    public function isInternal()
    {
        return $this->id === self::INTERNAL;
    }

    public function isGoogle()
    {
        return $this->id === self::GOOGLE;
    }

    public function isFacebook()
    {
        return $this->id === self::FACEBOOK;
    }

    public function isTwitter()
    {
        return $this->id === self::TWITTER;
    }

    public function isYahoo()
    {
        return $this->id === self::YAHOO;
    }
}
