<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use DateTimeZone;

trait CreatedTrait
{
    /** @var int */
    protected $created;

    public function setCreated(DateTime $created = null)
    {
        if ($created === null) {
            $created = new DateTime('now', new DateTimeZone('UTC'));
        }

        $this->created = $created->getTimestamp();
    }

    public function getCreated(): DateTime
    {
        $created = new DateTime();
        $created->setTimestamp($this->created);
        return $created;
    }
}
