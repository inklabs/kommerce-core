<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductQuantityDiscountCommand;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Service\ProductServiceInterface;

final class CreateProductQuantityDiscountHandler
{
    /** @var ProductServiceInterface */
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(CreateProductQuantityDiscountCommand $command)
    {
        $product = $this->productService->findOneById(
            $command->getProductId()
        );

        $productQuantityDiscount = new ProductQuantityDiscount(
            $product,
            $command->getProductQuantityDiscountId()
        );

        $productQuantityDiscount->setType(PromotionType::createById($command->getPromotionTypeId()));
        $productQuantityDiscount->setValue($command->getValue());
        $productQuantityDiscount->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $productQuantityDiscount->setMaxRedemptions($command->getMaxRedemptions());
        $productQuantityDiscount->setStart($command->getStartDate());
        $productQuantityDiscount->setEnd($command->getEndDate());
        $productQuantityDiscount->setQuantity($command->getQuantity());
        $productQuantityDiscount->setFlagApplyCatalogPromotions($command->getFlagApplyCatalogPromotions());

        $this->productService->createProductQuantityDiscount($productQuantityDiscount);
    }
}
