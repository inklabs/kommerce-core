<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Lib\UuidInterface;

class UserTokenRepository extends AbstractRepository implements UserTokenRepositoryInterface
{
    public function findLatestOneByUserId(UuidInterface $userUserId)
    {
        $userToken = $this->getQueryBuilder()
            ->select('UserToken')
            ->from(UserToken::class, 'UserToken')
            ->where('User.id = :userId')
            ->setIdParameter('userId', $userUserId)
            ->orderBy('UserToken.created', 'desc')

            ->addSelect('User')
            ->leftJoin('UserToken.user', 'User')

            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->returnOrThrowNotFoundException($userToken);
    }
}
