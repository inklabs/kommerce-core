<?php
namespace inklabs\kommerce\Entity\Accessor;

use Doctrine\ORM\Event\PreUpdateEventArgs;

trait Updated
{
    /** @var int */
    protected $updated;

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated = null)
    {
        if ($updated === null) {
            $updated = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        $this->updated = $updated->getTimestamp();
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

    public function preUpdate(PreUpdateEventArgs $event = null)
    {
        $this->setUpdated();
    }
}
