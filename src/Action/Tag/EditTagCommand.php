<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Lib\Command\CommandInterface;

class EditTagCommand implements CommandInterface
{
    /** @var Tag */
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }
}
