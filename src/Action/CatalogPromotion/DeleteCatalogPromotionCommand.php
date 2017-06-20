<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCatalogPromotionCommand implements CommandInterface
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
