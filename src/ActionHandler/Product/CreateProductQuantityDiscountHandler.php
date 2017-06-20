<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductQuantityDiscountCommand;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityRepository\ProductQuantityDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateProductQuantityDiscountHandler implements CommandHandlerInterface
{
    /** @var CreateProductQuantityDiscountCommand */
    private $command;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductQuantityDiscountRepositoryInterface */
    private $productQuantityDiscountRepository;

    public function __construct(
        CreateProductQuantityDiscountCommand $command,
        ProductRepositoryInterface $productRepository,
        ProductQuantityDiscountRepositoryInterface $productQuantityDiscountRepository
    ) {
        $this->command = $command;
        $this->productRepository = $productRepository;
        $this->productQuantityDiscountRepository = $productQuantityDiscountRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $product = $this->productRepository->findOneById(
            $this->command->getProductId()
        );

        $productQuantityDiscount = new ProductQuantityDiscount(
            $product,
            $this->command->getProductQuantityDiscountId()
        );
        $productQuantityDiscount->setType(PromotionType::createById($this->command->getPromotionTypeId()));
        $productQuantityDiscount->setValue($this->command->getValue());
        $productQuantityDiscount->setReducesTaxSubtotal($this->command->getReducesTaxSubtotal());
        $productQuantityDiscount->setMaxRedemptions($this->command->getMaxRedemptions());
        $productQuantityDiscount->setStart($this->command->getStartDate());
        $productQuantityDiscount->setEnd($this->command->getEndDate());
        $productQuantityDiscount->setQuantity($this->command->getQuantity());
        $productQuantityDiscount->setFlagApplyCatalogPromotions($this->command->getFlagApplyCatalogPromotions());

        $this->productQuantityDiscountRepository->create($productQuantityDiscount);
    }
}
