<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Exception\BadMethodCallException;

class UserLoginRepository extends AbstractRepository implements UserLoginRepositoryInterface
{
    public function update(EntityInterface & $entity): void
    {
        throw new BadMethodCallException('Update not allowed');
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return UserLogin[]
     */
    public function getAllUserLogins(string $queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('UserLogin')
            ->from(UserLogin::class, 'UserLogin');

        if (trim($queryString) !== '') {
            $query
                ->orWhere('UserLogin.email LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
