<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\InventoryLocation;
use Ramsey\Uuid\UuidInterface;

/**
 * @method InventoryLocation findOneById(UuidInterface $id)
 */
interface InventoryLocationRepositoryInterface extends RepositoryInterface
{
}
