<?php
namespace inklabs\kommerce\Entity\Accessor;

use Doctrine\ORM\Event\PreUpdateEventArgs;

trait Updated
{
    protected $updated;

    public function setUpdated(\DateTime $updated = null)
    {
        if ($updated === null) {
            $updated = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        $this->updated = $updated->getTimestamp();
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $this->setUpdated();
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        if (empty($this->updated)) {
            return null;
        }

        $updated = new \DateTime();
        $updated->setTimestamp($this->updated);
        return $updated;
    }
}
