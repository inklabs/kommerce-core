<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\CommandInterface;
use inklabs\kommerce\Entity\Tag;

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
