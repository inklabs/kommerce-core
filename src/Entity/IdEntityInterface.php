<?php
namespace inklabs\kommerce\Entity;

use Ramsey\Uuid\UuidInterface;

interface IdEntityInterface extends EntityInterface
{
    /** @return UuidInterface */
    public function getId();

    public function setId(UuidInterface $id);
}
