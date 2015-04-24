<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\User find($id)
 */
class User extends AbstractEntityRepository implements UserInterface
{
    public function getAllUsers($queryString = null, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $users = $qb->select('user')
            ->from('kommerce:user', 'user');

        if ($queryString !== null) {
            $users = $users
                ->where('user.firstName LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $users = $users
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $users;
    }

    public function getAllUsersByIds($userIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $users = $qb->select('user')
            ->from('kommerce:User', 'user')
            ->where('user.id IN (:userIds)')
            ->setParameter('userIds', $userIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $users;
    }

    public function findOneByEmail($email)
    {
        $qb = $this->getQueryBuilder();

        $user = $qb
            ->select('user')
            ->from('kommerce:User', 'user')

            ->addSelect('userRole')
            ->leftJoin('user.roles', 'userRole')

            ->where('user.email = :email')->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }
}
