<?php
namespace inklabs\kommerce\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait TempUuidTrait
{
    /** @var UuidInterface */
    protected $uuid;

    public function setUuid(UuidInterface $uuid = null)
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4();
        }

        $this->uuid = $uuid;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}
