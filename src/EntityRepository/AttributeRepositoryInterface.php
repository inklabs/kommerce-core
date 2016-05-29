<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Attribute findOneById(UuidInterface $id)
 */
interface AttributeRepositoryInterface extends RepositoryInterface
{
}
