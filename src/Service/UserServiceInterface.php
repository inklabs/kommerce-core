<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\UserLoginException;

interface UserServiceInterface
{
    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp
     * @return User
     * @throws UserLoginException
     */
    public function login($email, $password, $remoteIp);

    /**
     * @param string $email
     * @param string $token
     * @param string $remoteIp
     * @return User
     * @throws UserLoginException
     */
    public function loginWithToken($email, $token, $remoteIp);
}
