<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\CreateCatalogPromotionCommand;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Service\CatalogPromotionServiceInterface;
use inklabs\kommerce\Service\TagServiceInterface;

final class CreateCatalogPromotionHandler
{
    /** @var CatalogPromotionServiceInterface */
    protected $catalogPromotionService;

    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(
        CatalogPromotionServiceInterface $catalogPromotionService,
        TagServiceInterface $tagService
    ) {
        $this->catalogPromotionService = $catalogPromotionService;
        $this->tagService = $tagService;
    }

    public function handle(CreateCatalogPromotionCommand $command)
    {
        $catalogPromotion = new CatalogPromotion(
            $command->getCatalogPromotionId()
        );

        $catalogPromotion->setName($command->getName());
        $catalogPromotion->setType(PromotionType::createById($command->getPromotionTypeId()));
        $catalogPromotion->setValue($command->getValue());
        $catalogPromotion->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $catalogPromotion->setStart($command->getStartDate());
        $catalogPromotion->setEnd($command->getEndDate());

        if ($command->getTagId() !== null) {
            $tag = $this->tagService->findOneById($command->getTagId());
            $catalogPromotion->setTag($tag);
        }

        $this->catalogPromotionService->create($catalogPromotion);
    }
}
