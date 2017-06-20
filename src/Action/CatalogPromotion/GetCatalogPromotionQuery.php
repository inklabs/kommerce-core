<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCatalogPromotionQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $catalogPromotionId;

    public function __construct(string $catalogPromotionId)
    {
        $this->catalogPromotionId = Uuid::fromString($catalogPromotionId);
    }

    public function getCatalogPromotionId(): UuidInterface
    {
        return $this->catalogPromotionId;
    }
}
