<?php
namespace inklabs\kommerce\Action\Image;

use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class CreateImageCommand implements CommandInterface
{
    /** @var ImageDTO */
    private $imageDTO;

    /** @var int */
    protected $tagId;

    public function __construct(ImageDTO $imageDTO)
    {
        $this->imageDTO = $imageDTO;
    }

    public function getImageDTO()
    {
        return $this->imageDTO;
    }

    public function setTagId($tagId)
    {
        $this->tagId = (int) $tagId;
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
