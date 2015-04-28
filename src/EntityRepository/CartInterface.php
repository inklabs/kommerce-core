<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartInterface
{
    /**
     * @param int $id
     * @return Entity\Cart
     */
    public function find($id);

    /**
     * @param Entity\Cart $cart
     */
    public function save(Entity\Cart & $cart);

    /**
     * @param Entity\Cart $cart
     */
    public function create(Entity\Cart & $cart);
}
