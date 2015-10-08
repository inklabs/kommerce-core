<?php
namespace inklabs\kommerce\EntityRepository;

class CartRepository extends AbstractRepository implements CartRepositoryInterface
{
    public function findOneByUser($userId)
    {
        return $this->findOneBy(['user' => $userId]);
    }

    public function findOneBySession($sessionId)
    {
        return $this->findOneBy(['sessionId' => $sessionId]);
    }
}
