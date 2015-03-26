<?php
namespace inklabs\kommerce\Entity\Accessor;

trait Id
{
    /** @var int */
    protected $id;

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
