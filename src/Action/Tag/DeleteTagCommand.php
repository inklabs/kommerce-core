<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final class DeleteTagCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
