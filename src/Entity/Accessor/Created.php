<?php
namespace inklabs\kommerce\Entity\Accessor;

trait Created
{
    /** @Column(type="integer") **/
    protected $created;

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }
}
