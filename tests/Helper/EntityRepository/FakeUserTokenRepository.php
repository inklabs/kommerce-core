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
}
