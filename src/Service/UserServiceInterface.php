<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Exception\UserLoginException;
use Ramsey\Uuid\UuidInterface;

interface UserServiceInterface
{
    public function create(User & $user);
    public function update(User & $user);

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

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsers($queryString = null, Pagination & $pagination = null);

    public function getAllUsersByIds($userIds, Pagination & $pagination = null);

    /**
     * @param string $getEmail
     * @param string $getUserAgent
     * @param string $getIp4
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function requestPasswordResetToken($getEmail, $getUserAgent, $getIp4);

    /**
     * @param int $userId
     * @param string $password
     */
    public function changePassword($userId, $password);
}
