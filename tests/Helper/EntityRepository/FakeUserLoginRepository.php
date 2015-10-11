<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;

/**
 * @method UserLogin findOneById($id)
 */
class FakeUserLoginRepository extends AbstractFakeRepository implements UserLoginRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new UserLogin);
    }

    public function getAllUsers($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllUsersByIds($userIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function findOneByEmail($email)
    {
        return $this->getReturnValue();
    }

    public function createUserLogin(UserLogin $userLogin)
    {
    }
}
