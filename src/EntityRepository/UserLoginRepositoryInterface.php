<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method UserLogin findOneById(UuidInterface $id)
 */
interface UserLoginRepositoryInterface extends RepositoryInterface
{
}
