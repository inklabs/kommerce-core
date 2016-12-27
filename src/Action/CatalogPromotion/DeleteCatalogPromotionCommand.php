<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCatalogPromotionCommand implements CommandInterface
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
