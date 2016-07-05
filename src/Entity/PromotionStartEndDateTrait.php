<?php
namespace inklabs\kommerce\Entity;

use DateTime;

trait PromotionStartEndDateTrait
{
    /** @var int | null */
    protected $start;

    /** @var int | null */
    protected $end;

    public function isDateValid(DateTime $date)
    {
        $currentDateTs = $date->getTimestamp();

        if (($this->start !== null) && ($currentDateTs < $this->start)) {
            return false;
        }

        if (($this->end !== null) && ($currentDateTs > $this->end)) {
            return false;
        }

        return true;
    }

    public function setStart(DateTime $start = null)
    {
        if ($start === null) {
            $this->start = null;
        } else {
            $this->start = $start->getTimestamp();
        }
    }

    public function getStart()
    {
        if ($this->start === null) {
            return null;
        }

        $start = new DateTime();
        $start->setTimestamp($this->start);
        return $start;
    }

    public function setEnd(DateTime $end = null)
    {
        if ($end === null) {
            $this->end = null;
        } else {
            $this->end = $end->getTimestamp();
        }
    }

    public function getEnd()
    {
        if ($this->end === null) {
            return null;
        }

        $end = new DateTime();
        $end->setTimestamp($this->end);
        return $end;
    }
}
