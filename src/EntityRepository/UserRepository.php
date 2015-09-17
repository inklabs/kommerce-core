<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function save(Entity\User & $user)
    {
        $this->saveEntity($user);
    }

    public function create(Entity\User & $user)
    {
        $this->createEntity($user);
    }

    public function remove(Entity\User & $user)
    {
        $this->removeEntity($user);
    }

    public function getAllUsers($queryString = null, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $users = $qb->select('user')
            ->from('kommerce:user', 'user');

        if ($queryString !== null) {
            $users = $users
                ->where('user.firstName LIKE :query')
                ->orWhere('user.lastName LIKE :query')
                ->orWhere('user.email LIKE :query')
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
