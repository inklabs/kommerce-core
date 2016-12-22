<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\UpdateCatalogPromotionCommand;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\Service\CatalogPromotionServiceInterface;

final class UpdateCatalogPromotionHandler
{
    /** @var CatalogPromotionServiceInterface */
    protected $couponService;

    public function __construct(CatalogPromotionServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(UpdateCatalogPromotionCommand $command)
    {
        $couponDTO = $command->getCatalogPromotionDTO();
        $coupon = $this->couponService->findOneById($couponDTO->id);
        CatalogPromotionDTOBuilder::setFromDTO($coupon, $couponDTO);

        $this->couponService->update($coupon);
    }
}
