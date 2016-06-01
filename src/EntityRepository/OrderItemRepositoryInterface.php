<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method OrderItem|null findOneById(UuidInterface $id)
 */
interface OrderItemRepositoryInterface extends RepositoryInterface
{
}
