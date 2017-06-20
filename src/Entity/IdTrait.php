<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

trait IdTrait
{
    /** @var UuidInterface */
    protected $id;

    public function setId(UuidInterface $uuid = null)
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4();
        }

        $this->id = $uuid;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
