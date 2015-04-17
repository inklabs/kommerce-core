<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartPriceRuleInterface
{
    /**
     * @return Entity\Product
     */
    public function find($id);

    /**
     * @return Entity\Product[]
     */
    public function findAll();
}
