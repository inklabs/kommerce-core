<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\CreateCatalogPromotionCommand;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCatalogPromotionHandler implements CommandHandlerInterface
{
    /** @var CreateCatalogPromotionCommand */
    private $command;

    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        CreateCatalogPromotionCommand $command,
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->command = $command;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->tagRepository = $tagRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $catalogPromotion = new CatalogPromotion(
            $this->command->getCatalogPromotionId()
        );

        $catalogPromotion->setName($this->command->getName());
        $catalogPromotion->setType($this->command->getPromotionType());
        $catalogPromotion->setValue($this->command->getValue());
        $catalogPromotion->setReducesTaxSubtotal($this->command->getReducesTaxSubtotal());
        $catalogPromotion->setMaxRedemptions($this->command->getMaxRedemptions());
        $catalogPromotion->setStartAt($this->command->getStartAt());
        $catalogPromotion->setEndAt($this->command->getEndAt());

        if ($this->command->getTagId() !== null) {
            $tag = $this->tagRepository->findOneById($this->command->getTagId());
            $catalogPromotion->setTag($tag);
        }

        $this->catalogPromotionRepository->create($catalogPromotion);
    }
}
