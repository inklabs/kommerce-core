<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartInterface
{
    /**
     * @param Entity\Cart $cart
     */
    public function save(Entity\Cart & $cart);

    /**
     * @param Entity\Cart $cart
     */
    public function create(Entity\Cart & $cart);

    /**
     * @param int $id
     * @return Entity\Cart
     */
    public function find($id);

    /**
     * @param int $userId
     * @param string $sessionId
     * @return Entity\Cart
     * @throws \LogicException
     */
    public function findByUserOrSession($userId, $sessionId);
}
