<?php
namespace inklabs\kommerce\Action\Image;

use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final class CreateImageCommand implements CommandInterface
{
    /** @var ImageDTO */
    private $imageDTO;

    /** @var UuidInterface */
    protected $tagId;

    public function __construct(ImageDTO $imageDTO, UuidInterface $tagId)
    {
        $this->imageDTO = $imageDTO;
        $this->tagId = $tagId;
    }

    public function getImageDTO()
    {
        return $this->imageDTO;
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
