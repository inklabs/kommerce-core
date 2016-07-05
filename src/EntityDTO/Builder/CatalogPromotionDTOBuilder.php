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
    protected $entity;

    /** @var CatalogPromotionDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new CatalogPromotionDTO;
    }

    protected function preBuild()
    {
        parent::preBuild();
        $this->entityDTO->code = $this->entity->getCode();
    }

    /**
     * @return static
     */
    private function withTag()
    {
        $tag = $this->entity->getTag();
        if ($tag !== null) {
            $this->entityDTO->tag = $this->dtoBuilderFactory
                ->getTagDTOBuilder($tag)
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withTag();
    }
}
