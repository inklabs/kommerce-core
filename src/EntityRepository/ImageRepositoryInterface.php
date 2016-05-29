<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Image;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Image findOneById(UuidInterface $id)
 */
interface ImageRepositoryInterface extends RepositoryInterface
{
}
