<?php
namespace inklabs\kommerce\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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

    public function getId()
    {
        return $this->id;
    }
}
