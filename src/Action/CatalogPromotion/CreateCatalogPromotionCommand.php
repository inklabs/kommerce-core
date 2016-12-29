<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Uuid;

final class CreateCatalogPromotionCommand extends AbstractCatalogPromotionCommand
{
    /**
     * @param string $name
     * @param int $promotionTypeSlug
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param int $startAt
     * @param int $endAt
     * @param string|null $tagId
     */
    public function __construct(
        $name,
        $promotionTypeSlug,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startAt,
        $endAt,
        $tagId = null
    ) {
        return parent::__construct(
            $name,
            $promotionTypeSlug,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startAt,
            $endAt,
            Uuid::uuid4(),
            $tagId
        );
    }
}
