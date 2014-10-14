<?php
namespace inklabs\kommerce\Entity;

trait TimeAccessors
{
    /** @Column(type="integer") **/
    protected $created;

    /** @Column(type="integer") **/
    protected $updated;

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

    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    public function getUpdated()
    {
        $updated = new \DateTime();
        $updated->setTimestamp($this->updated);
        return $updated;
    }
}
