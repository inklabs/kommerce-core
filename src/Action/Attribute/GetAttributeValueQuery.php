<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetAttributeValueQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $attributeValueId;

    public function __construct(string $attributeValueId)
    {
        $this->attributeValueId = Uuid::fromString($attributeValueId);
    }

    public function getAttributeValueId(): UuidInterface
    {
        return $this->attributeValueId;
    }
}
