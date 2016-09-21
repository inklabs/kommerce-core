<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;
use DateTime;

final class CreateCatalogPromotionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $catalogPromotionId;

    /** @var string */
    private $name;

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

    /** @var UuidInterface|null */
    private $tagId;

    /**
     * @param string $name
     * @param int $promotionTypeId
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param string|null $tagId
     */
    public function __construct(
        $name,
        $promotionTypeId,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startDate,
        $endDate,
        $tagId = null
    ) {
        $this->catalogPromotionId = Uuid::uuid4();
        $this->name = $name;
        $this->promotionTypeId = $promotionTypeId;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        if ($tagId !== null) {
            $this->tagId = Uuid::fromString($tagId);
        }
    }

    public function getCatalogPromotionId()
    {
        return $this->catalogPromotionId;
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

    public function getTagId()
    {
        return $this->tagId;
    }
}
