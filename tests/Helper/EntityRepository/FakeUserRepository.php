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
    protected $entityName = 'User';

    /** @var User[] */
    protected $entities = [];

    public function __construct()
    {
        $this->setReturnValue(new User);
    }

    public function findOneByEmail($email)
    {
        foreach ($this->entities as $entity) {
            if ($entity->getEmail() === $email) {
                return $entity;
            }
        }
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
