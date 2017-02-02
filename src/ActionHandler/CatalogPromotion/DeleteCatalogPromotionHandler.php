<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\DeleteCatalogPromotionCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteCatalogPromotionHandler implements CommandHandlerInterface
{
    /** @var DeleteCatalogPromotionCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $catalogPromotionRepository;

    public function __construct(
        DeleteCatalogPromotionCommand $command,
        CatalogPromotionRepositoryInterface $catalogPromotionRepository
    ) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRuleDiscount = $this->catalogPromotionRepository->findOneById(
            $this->command->getCatalogPromotionId()
        );

        $this->catalogPromotionRepository->delete($cartPriceRuleDiscount);
    }
}
