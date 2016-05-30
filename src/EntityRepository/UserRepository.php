<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function findOneByEmail($email)
    {
        $user = $this->getQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')

            ->addSelect('userRole')
            ->leftJoin('User.userRoles', 'userRole')

            ->where('User.email = :email')->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->returnOrThrowNotFoundException($user);
    }

    public function findOneByExternalId($externalId)
    {
        return parent::findOneBy(['externalId' => $externalId]);
    }

    public function getAllUsers($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('User')
            ->from(User::class, 'User');

        if ($queryString !== null) {
            $query
                ->where('User.firstName LIKE :query')
                ->orWhere('User.lastName LIKE :query')
                ->orWhere('User.email LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllUsersByIds($userIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')
            ->where('User.id IN (:userIds)')
            ->setIdParameter('userIds', $userIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
