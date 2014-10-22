<?php
namespace inklabs\kommerce\Entity\Accessor;

trait Created
{
    protected $created;

    public function setCreated(\DateTime $created = null)
    {
        if ($created === null) {
            $created = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        $this->created = $created->gettimestamp();
    }

    public function getCreated()
    {
        $created = new \DateTime();
        $created->setTimestamp($this->created);
        return $created;
    }
}
