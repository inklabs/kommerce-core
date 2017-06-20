<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserLoginResultType extends AbstractIntegerType
{
    const FAIL    = 0;
    const SUCCESS = 1;

    public static function getNameMap(): array
    {
        return [
            self::FAIL => 'Fail',
            self::SUCCESS => 'Success',
        ];
    }

    public static function getSlugMap(): array
    {
        return [
            self::FAIL => 'fail',
            self::SUCCESS => 'success',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The result is not a valid choice',
        ]));
    }

    public static function fail()
    {
        return new self(self::FAIL);
    }

    public static function success()
    {
        return new self(self::SUCCESS);
    }

    public function isFail()
    {
        return $this->id === self::FAIL;
    }

    public function isSuccess()
    {
        return $this->id === self::SUCCESS;
    }
}
