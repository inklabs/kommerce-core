<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartPriceRuleInterface
{
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
