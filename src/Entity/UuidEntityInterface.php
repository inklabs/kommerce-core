<?php
namespace inklabs\kommerce\Entity;

use Ramsey\Uuid\UuidInterface;

interface UuidEntityInterface extends EntityInterface
{
    /** @return UuidInterface */
    public function getId();
    public function setId(UuidInterface $uuid = null);
}
