<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

class User extends EntityRepository
{
    public function findOneByUsernameOrEmail($username)
    {
        $qb = $this->getQueryBuilder();

        $user = $qb
            ->select('user')
            ->from('kommerce:User', 'user')
            ->where('user.username = :username')->setParameter('username', $username)
            ->orWhere('user.email = :email')->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }
}
