<?php
namespace inklabs\kommerce\Entity\Accessor;

use Doctrine\ORM\Event\LifecycleEventArgs;

trait Created
{
    /** @var int */
    protected $created;

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created = null)
    {
        if ($created === null) {
            $created = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        $this->created = $created->gettimestamp();
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        $created = new \DateTime();
        $created->setTimestamp($this->created);
        return $created;
    }
}
