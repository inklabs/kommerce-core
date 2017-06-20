<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductsByTagQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $tagId;

    /** @var PaginationDTO */
    private $paginationDTO;

    public function __construct(string $tagId, PaginationDTO $paginationDTO)
    {
        $this->tagId = Uuid::fromString($tagId);
        $this->paginationDTO = $paginationDTO;
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTO;
    }
}
