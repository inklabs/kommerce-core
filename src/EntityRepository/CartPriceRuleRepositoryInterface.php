<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;
use Ramsey\Uuid\UuidInterface;

/**
 * @method CartPriceRule findOneById(UuidInterface $id)
 */
interface CartPriceRuleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return CartPriceRule[]
     */
    public function findAll();
}
