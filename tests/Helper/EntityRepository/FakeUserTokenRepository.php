<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;

/**
 * @method UserToken findOneById($id)
 */
class FakeUserTokenRepository extends AbstractFakeRepository implements UserTokenRepositoryInterface
{
    protected $entityName = 'UserToken';

    /** @var UserToken[] */
    protected $entities = [];

    public function findLatestOneByUserId($userUserId)
    {
        foreach ($this->entities as $entity) {
            if ($entity->getUser()->getId() === $userUserId) {
                return $entity;
            }
        }

        throw $this->getEntityNotFoundException();
    }
}
