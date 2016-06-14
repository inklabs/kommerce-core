<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;

interface IdEntityInterface extends EntityInterface
{
    /** @return UuidInterface */
    public function getId();

    public function setId(UuidInterface $id);
}
