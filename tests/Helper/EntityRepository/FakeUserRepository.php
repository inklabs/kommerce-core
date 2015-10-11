<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;

/**
 * @method User findOneById($id)
 */
class FakeUserRepository extends AbstractFakeRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new User);
    }

    public function findOneByEmail($email)
    {
        return $this->getReturnValue();
    }

    public function findOneByExternalId($externalId)
    {
        return $this->getReturnValue();
    }

    public function getAllUsers($queryString = null, Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllUsersByIds($userIds, Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function createUserLogin(UserLogin $userLogin)
    {
    }
}
