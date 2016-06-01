<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Image findOneById(UuidInterface $id)
 */
interface ImageRepositoryInterface extends RepositoryInterface
{
}
