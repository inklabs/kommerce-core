<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;

/**
 * @method CatalogPromotionDTO build()
 */
class CatalogPromotionDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var CatalogPromotion */
    protected $promotion;

    /** @var CatalogPromotionDTO */
    protected $promotionDTO;

    protected function getPromotionDTO()
    {
        return new CatalogPromotionDTO;
    }

    protected function preBuild()
    {
        parent::preBuild();
        $this->promotionDTO->code = $this->promotion->getCode();
    }

    private function withTag()
    {
        $tag = $this->promotion->getTag();
        if ($tag !== null) {
            $this->promotionDTO->tag = $this->dtoBuilderFactory
                ->getTagDTOBuilder($tag)
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag();
    }
}
