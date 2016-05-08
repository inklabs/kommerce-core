<?php
namespace inklabs\kommerce\Entity;

interface IdEntityInterface extends EntityInterface
{
    /** @return int */
    public function getId();

    /** @var int $id */
    public function setId($id);
}
