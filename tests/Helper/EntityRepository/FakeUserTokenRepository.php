<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;

class FakeUserTokenRepository extends AbstractFakeRepository implements UserTokenRepositoryInterface
{
    protected $entityName = 'UserToken';

    /** @var UserToken[] */
    protected $entities = [];

    public function findLatestOneByUserId($userId)
    {
        foreach ($this->entities as $entity) {
            if ($entity->getUser()->getId() === $userId) {
                return $entity;
            }
        }

        throw $this->getEntityNotFoundException();
    }
}
