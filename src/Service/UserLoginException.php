<?php
namespace inklabs\kommerce\Service;

class UserLoginException extends \Exception
{
    const USER_NOT_FOUND = 0;
    const USER_NOT_ACTIVE = 1;
    const INVALID_PASSWORD = 2;
}
