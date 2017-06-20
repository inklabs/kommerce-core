<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

trait PromotionStartEndDateTrait
{
    /** @var int|null */
    protected $start;

    /** @var int|null */
    protected $end;

    public static function loadPromotionStartEndDateValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('start', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('end', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));
    }

    public function isDateValid(DateTime $date): bool
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

    public function setStartAt(int $startAt)
    {
        $this->start = $startAt;
    }

    public function getStartAt(): ?int
    {
        return $this->start;
    }

    public function setEndAt(int $endAt)
    {
        $this->end = $endAt;
    }

    public function getEndAt(): ?int
    {
        return $this->end;
    }

    public function setStart(DateTime $start = null)
    {
        if ($start === null) {
            $this->start = null;
        } else {
            $this->start = $start->getTimestamp();
        }
    }

    public function getStart(): ?DateTime
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

    public function getEnd(): ?DateTime
    {
        if ($this->end === null) {
            return null;
        }

        $end = new DateTime();
        $end->setTimestamp($this->end);
        return $end;
    }
}
