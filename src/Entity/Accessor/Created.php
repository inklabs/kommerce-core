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
        $created = new \DateTime();
        $created->setTimestamp($this->created);
        return $created;
    }
}
