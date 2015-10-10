<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
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

    public function findOneByExternalId($externalId)
    {
        return parent::findOneBy(['externalId' => $externalId]);
    }

    public function getAllUsers($queryString = null, Pagination & $pagination = null)
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

    public function getAllUsersByIds($userIds, Pagination & $pagination = null)
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
}
