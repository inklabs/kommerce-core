<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartPriceRuleRepositoryInterface
{
    public function save(Entity\CartPriceRule & $cartPriceRule);
    public function create(Entity\CartPriceRule & $cartPriceRule);
    public function remove(Entity\CartPriceRule & $cartPriceRule);

    /**
     * @param int $id
     * @return Entity\CartPriceRule
     */
    public function find($id);

    /**
     * @return Entity\CartPriceRule[]
     */
    public function findAll();
}
