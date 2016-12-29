<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\UpdateCatalogPromotionCommand;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

final class UpdateCatalogPromotionHandler
{
    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->tagRepository = $tagRepository;
    }

    public function handle(UpdateCatalogPromotionCommand $command)
    {
        $catalogPromotion = $this->catalogPromotionRepository->findOneById(
            $command->getCatalogPromotionId()
        );

        $catalogPromotion->setName($command->getName());
        $catalogPromotion->setType($command->getPromotionType());
        $catalogPromotion->setValue($command->getValue());
        $catalogPromotion->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $catalogPromotion->setMaxRedemptions($command->getMaxRedemptions());
        $catalogPromotion->setStartAt($command->getStartAt());
        $catalogPromotion->setEndAt($command->getEndAt());

        if ($command->getTagId() === null) {
            $catalogPromotion->setTag(null);
        } else {
            $tag = $this->tagRepository->findOneById($command->getTagId());
            $catalogPromotion->setTag($tag);
        }

        $this->catalogPromotionRepository->update($catalogPromotion);
    }
}
