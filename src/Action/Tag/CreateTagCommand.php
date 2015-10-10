<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Lib\Command\CommandInterface;

class CreateTagCommand implements CommandInterface
{
    /** @var Tag */
    private $tag;

    /** @var int */
    private $returnId;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setReturnId($returnId)
    {
        $this->returnId = $returnId;
    }

    public function getReturnId()
    {
        return $this->returnId;
    }
}
