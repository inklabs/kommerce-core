<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\Entity\TimeTrait;
use inklabs\kommerce\EntityDTO\TimeDTOTrait;

/**
 * @property TimeTrait entity
 * @property TimeDTOTrait entityDTO
 */
trait TimeDTOBuilderTrait
{
    protected $dateFormat = 'F j, Y';
    protected $timeFormat = 'g:i a T';
    protected $timezone = 'America/Los_Angeles';

    public function setTime()
    {
        $this->entityDTO->created = $this->entity->getCreated();
        $this->entityDTO->updated = $this->entity->getUpdated();

        if ($this->entityDTO->created !== null) {
            $this->entityDTO->createdFormatted = $this->formatDateTime($this->entityDTO->created);
        }

        if ($this->entityDTO->updated !== null) {
            $this->entityDTO->updatedFormatted = $this->formatDateTime($this->entityDTO->updated);
        }
    }

    private function formatDate(DateTime $dateTime = null, $format = null)
    {
        if ($format === null) {
            $format = $this->timeFormat;
        }

        $output = new DateTime();
        $output->setTimestamp($dateTime->getTimestamp());
        $output->setTimezone(new DateTimeZone($this->timezone));
        return $output->format($format);
    }

    private function formatTime(DateTime $dateTime = null)
    {
        return $this->formatDate(
            $dateTime,
            $this->timeFormat
        );
    }

    private function formatDateTime(DateTime $dateTime = null)
    {
        return $this->formatDate(
            $dateTime,
            $this->dateFormat . ' ' .
            $this->timeFormat
        );
    }
}
