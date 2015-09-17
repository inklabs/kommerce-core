<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartRepositoryInterface
{
    public function save(Entity\Cart & $cart);
    public function create(Entity\Cart & $cart);
    public function remove(Entity\Cart & $cart);

    /**
     * @param int $id
     * @return Entity\Cart
     */
    public function find($id);

    /**
     * @param int $userId
     * @return Entity\Cart|null
     */
    public function findByUser($userId);

    /**
     * @param string $sessionId
     * @return Entity\Cart|null
     */
    public function findBySession($sessionId);
}
