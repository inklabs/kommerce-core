<?php
namespace inklabs\kommerce\Entity\Accessor;

class UpdatedListener
{
    public function preUpdate($event)
    {
        $updated = new \DateTime();
        $this->updated = $updated->getTimestamp();
    }
}
