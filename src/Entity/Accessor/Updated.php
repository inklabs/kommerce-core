<?php
namespace inklabs\kommerce\Entity\Accessor;

trait Updated
{
    /** @Column(type="integer") **/
    protected $updated;

    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}
