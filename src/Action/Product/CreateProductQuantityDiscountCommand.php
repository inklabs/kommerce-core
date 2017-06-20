<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;
use DateTime;

final class CreateProductQuantityDiscountCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productQuantityDiscountId;

    /** @var int */
    private $promotionTypeId;

    /** @var int */
    private $value;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int|null */
    private $maxRedemptions;

    /** @var DateTime */
    private $startDate;

    /** @var DateTime */
    private $endDate;

    /** @var UuidInterface */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var bool */
    private $flagApplyCatalogPromotions;

    public function __construct(
        int $promotionTypeId,
        int $value,
        bool $reducesTaxSubtotal,
        ?int $maxRedemptions,
        DateTime $startDate,
        DateTime $endDate,
        string $productId,
        int $quantity,
        bool $flagApplyCatalogPromotions
    ) {
        $this->promotionTypeId = $promotionTypeId;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
        $this->flagApplyCatalogPromotions = $flagApplyCatalogPromotions;
        $this->productQuantityDiscountId = Uuid::uuid4();
    }

    public function getProductQuantityDiscountId(): UuidInterface
    {
        return $this->productQuantityDiscountId;
    }

    public function getPromotionTypeId(): int
    {
        return $this->promotionTypeId;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getReducesTaxSubtotal(): bool
    {
        return $this->reducesTaxSubtotal;
    }

    public function getMaxRedemptions(): ?int
    {
        return $this->maxRedemptions;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getFlagApplyCatalogPromotions(): bool
    {
        return $this->flagApplyCatalogPromotions;
    }
}
