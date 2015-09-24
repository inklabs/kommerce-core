<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CatalogPromotion;
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

    public function __construct(CatalogPromotion $catalogPromotionInvalid)
    {
        $this->promotionDTO = new CatalogPromotionDTO;

        parent::__construct($catalogPromotionInvalid);

        $this->promotionDTO->code = $this->promotion->getCode();
    }

    private function withTag()
    {
        $tag = $this->promotion->getTag();
        if ($tag !== null) {
            $this->promotionDTO->tag = $tag->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag();
    }

//    public function build()
//    {
//        return $this->promotionDTO;
//    }
}
