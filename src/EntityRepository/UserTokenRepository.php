<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;

class UserTokenRepository extends AbstractRepository implements UserTokenRepositoryInterface
{
    public function findLatestOneByUserId($userId)
    {
        $userToken = $this->getQueryBuilder()
            ->select('UserToken')
            ->from(UserToken::class, 'UserToken')
            ->leftJoin('UserToken.user', 'User')
            ->where('User.id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('UserToken.created', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->returnOrThrowNotFoundException($userToken);
    }
}
