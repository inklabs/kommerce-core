<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserLogin;
use Ramsey\Uuid\UuidInterface;

/**
 * @method UserLogin findOneById(UuidInterface $id)
 */
interface UserLoginRepositoryInterface extends RepositoryInterface
{
}
