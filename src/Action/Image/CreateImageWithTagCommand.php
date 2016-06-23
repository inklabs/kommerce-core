<?php
namespace inklabs\kommerce\Action\Image;

use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateImageWithTagCommand implements CommandInterface
{
    /** @var ImageDTO */
    private $imageDTO;

    /** @var UuidInterface */
    protected $tagId;

    /**
     * CreateImageWithTagCommand constructor.
     * @param ImageDTO $imageDTO
     * @param string $tagId
     */
    public function __construct($tagId, ImageDTO $imageDTO)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->imageDTO = $imageDTO;
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
