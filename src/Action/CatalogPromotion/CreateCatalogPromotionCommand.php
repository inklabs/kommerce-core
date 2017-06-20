<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Uuid;

final class CreateCatalogPromotionCommand extends AbstractCatalogPromotionCommand
{
    public function __construct(
        string $name,
        string $promotionTypeSlug,
        int $value,
        bool $reducesTaxSubtotal,
        int $maxRedemptions,
        int $startAt,
        int $endAt,
        ?string $tagId = null
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
