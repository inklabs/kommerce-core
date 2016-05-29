<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class GetProductsByTagRequest
{
    /** @var UuidInterface */
    private $tagId;

    /** @var PaginationDTO */
    private $paginationDTO;

    /**
     * @param string $tagIdString
     * @param PaginationDTO $paginationDTO
     */
    public function __construct($tagIdString, PaginationDTO $paginationDTO)
    {
        $this->tagId = Uuid::fromString($tagIdString);
        $this->paginationDTO = $paginationDTO;
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
