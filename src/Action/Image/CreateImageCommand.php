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

    /**
     * @param ImageDTO $imageDTO
     * @param int $tagId
     */
    public function __construct(ImageDTO $imageDTO, $tagId)
    {
        $this->imageDTO = $imageDTO;
        $this->tagId = (int) $tagId;
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
