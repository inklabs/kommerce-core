<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\UserLoginException;

interface UserServiceInterface
{
    public function login(string $email, string $password, string $remoteIp): User;
    public function loginWithToken(string $email, string $token, string $remoteIp): User;
}
