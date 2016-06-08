<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method OrderItemOptionValue|null findOneById(UuidInterface $id)
 */
interface OrderItemOptionValueRepositoryInterface extends RepositoryInterface
{
}
