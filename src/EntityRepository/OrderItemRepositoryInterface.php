<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItem;
use Ramsey\Uuid\UuidInterface;

/**
 * @method OrderItem|null findOneById(UuidInterface $id)
 */
interface OrderItemRepositoryInterface extends RepositoryInterface
{
}
