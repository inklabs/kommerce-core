<?php
namespace inklabs\kommerce\Exception;

class UserPasswordValidationException extends KommerceException
{
    public static function matchesExistingPassword()
    {
        return new self('Invalid password');
    }

    public static function invalidLength()
    {
        return new self('Password must be at least 8 characters');
    }

    public static function tooSimilar()
    {
        return new self('Password is too similar to your name or email');
    }
}
