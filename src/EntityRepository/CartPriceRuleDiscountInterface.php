<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartPriceRuleDiscountInterface
{
    /**
     * @param int $id
     * @return Entity\CartPriceRuleDiscount
     */
    public function find($id);
}
