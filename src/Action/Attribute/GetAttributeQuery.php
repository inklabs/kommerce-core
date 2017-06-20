<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetAttributeQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $attributeId;

    public function __construct(string $attributeId)
    {
        $this->attributeId = Uuid::fromString($attributeId);
    }

    public function getAttributeId(): UuidInterface
    {
        return $this->attributeId;
    }
}
