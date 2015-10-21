<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function findOneByEmail($email)
    {
        return $this->getQueryBuilder()
            ->select('user')
            ->from('kommerce:User', 'user')

            ->addSelect('userRole')
            ->leftJoin('user.roles', 'userRole')

            ->where('user.email = :email')->setParameter('email', $email)
            ->getQuery()
            ->getSingleResult();
    }

    public function findOneByExternalId($externalId)
    {
        return parent::findOneBy(['externalId' => $externalId]);
    }

    public function getAllUsers($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('user')
            ->from('kommerce:user', 'user');

        if ($queryString !== null) {
            $query
                ->where('user.firstName LIKE :query')
                ->orWhere('user.lastName LIKE :query')
                ->orWhere('user.email LIKE :query')
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
            ->select('user')
            ->from('kommerce:User', 'user')
            ->where('user.id IN (:userIds)')
            ->setParameter('userIds', $userIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
