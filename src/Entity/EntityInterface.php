<?php
namespace inklabs\kommerce\Entity;

interface EntityInterface
{
    /** @return int */
    public function getId();

    /** @var $id */
    public function setId($id);
}
