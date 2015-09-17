<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CartPriceRuleDiscountRepositoryInterface
{
    /**
     * @param int $id
     * @return Entity\CartPriceRuleDiscount
     */
    public function find($id);
}
