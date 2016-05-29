<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use Ramsey\Uuid\UuidInterface;

/**
 * @method CartPriceRuleProductItem|CartPriceRuleTagItem findOneById(UuidInterface $id)
 */
interface CartPriceRuleItemRepositoryInterface extends RepositoryInterface
{
}
