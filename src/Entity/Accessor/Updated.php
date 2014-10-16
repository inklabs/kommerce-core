<?php
namespace inklabs\kommerce\Entity\Accessor;

trait Updated
{
    /** @Column(type="integer") **/
    protected $updated;

    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated->getTimestamp();
    }

    public function getUpdated()
    {
        $updated = new \DateTime();
        $updated->setTimestamp($this->updated);
        return $updated;
    }
}
