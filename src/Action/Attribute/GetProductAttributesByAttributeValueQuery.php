<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetProductAttributesByAttributeValueQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $attributeValueId;

    /** @var PaginationDTO */
    private $paginationDTO;

    public function __construct(string $attributeValueId, PaginationDTO $paginationDTO)
    {
        $this->attributeValueId = Uuid::fromString($attributeValueId);
        $this->paginationDTO = $paginationDTO;
    }

    public function getAttributeValueId(): UuidInterface
    {
        return $this->attributeValueId;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTO;
    }
}
