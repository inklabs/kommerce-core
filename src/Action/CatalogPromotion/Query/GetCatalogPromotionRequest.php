<?php
namespace inklabs\kommerce\Action\CatalogPromotion\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCatalogPromotionRequest
{
    /** @var UuidInterface */
    private $catalogPromotionId;

    /**
     * @param string $catalogPromotionId
     */
    public function __construct($catalogPromotionId)
    {
        $this->catalogPromotionId = Uuid::fromString($catalogPromotionId);
    }

    public function getCatalogPromotionId()
    {
        return $this->catalogPromotionId;
    }
}
