<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\DeleteCatalogPromotionCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;

final class DeleteCatalogPromotionHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    private $catalogPromotionRepository;

    public function __construct(CatalogPromotionRepositoryInterface $catalogPromotionRepository)
    {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    public function handle(DeleteCatalogPromotionCommand $command)
    {
        $cartPriceRuleDiscount = $this->catalogPromotionRepository->findOneById(
            $command->getCatalogPromotionId()
        );

        $this->catalogPromotionRepository->delete($cartPriceRuleDiscount);
    }
}
