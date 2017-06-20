<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;

interface IdEntityInterface extends EntityInterface
{
    public function getId(): UuidInterface;
    public function setId(UuidInterface $id);
}
