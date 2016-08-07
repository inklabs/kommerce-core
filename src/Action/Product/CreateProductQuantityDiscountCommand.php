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

    /** @var int */
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

    /**
     * @param int $promotionTypeId
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param string $productId
     * @param int $quantity
     * @param bool $flagApplyCatalogPromotions
     */
    public function __construct(
        $promotionTypeId,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startDate,
        $endDate,
        $productId,
        $quantity,
        $flagApplyCatalogPromotions
    ) {
        $this->productQuantityDiscountId = Uuid::uuid4();
        $this->promotionTypeId = $promotionTypeId;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
        $this->flagApplyCatalogPromotions = $flagApplyCatalogPromotions;
    }

    public function getProductQuantityDiscountId()
    {
        return $this->productQuantityDiscountId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPromotionTypeId()
    {
        return $this->promotionTypeId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getReducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function getMaxRedemptions()
    {
        return $this->maxRedemptions;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getFlagApplyCatalogPromotions()
    {
        return $this->flagApplyCatalogPromotions;
    }
}
