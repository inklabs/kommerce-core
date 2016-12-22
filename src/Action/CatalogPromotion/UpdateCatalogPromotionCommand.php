<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class UpdateCatalogPromotionCommand implements CommandInterface
{
    /** @var CatalogPromotionDTO */
    private $catalogPromotionDTO;

    public function __construct(CatalogPromotionDTO $catalogPromotionDTO)
    {
        $this->catalogPromotionDTO = $catalogPromotionDTO;
    }

    public function getCatalogPromotionDTO()
    {
        return $this->catalogPromotionDTO;
    }
}
