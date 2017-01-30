<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\Lib\UuidInterface;

interface UserServiceInterface
{
    public function create(User & $user);
    public function update(User & $user);
    public function createUserToken(UserToken & $userToken);

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

    /**
     * @param UuidInterface $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail($email);

    public function getAllUsersByIds($userIds, Pagination & $pagination = null);

    /**
     * @param UuidInterface $userId
     * @param string $password
     */
    public function changePassword(UuidInterface $userId, $password);
}
