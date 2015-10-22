<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

interface UserServiceInterface
{
    public function create(User & $user);
    public function update(User & $user);

    /**
     * @param int $userId
     */
    public function delete($userId);

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
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

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
