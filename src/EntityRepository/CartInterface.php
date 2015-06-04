<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartInterface
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
     * @return Entity\Cart
     */
    public function findByUser($userId);

    /**
     * @param string $sessionId
     * @return Entity\Cart
     */
    public function findBySession($sessionId);
}
