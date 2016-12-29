<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractCatalogPromotionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $catalogPromotionId;

    /** @var string */
    private $name;

    /** @var string */
    private $promotionTypeSlug;

    /** @var int */
    private $value;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int */
    private $maxRedemptions;

    /** @var int */
    private $startAt;

    /** @var int */
    private $endAt;

    /** @var UuidInterface|null */
    private $tagId;

    /**
     * @param string $name
     * @param int $promotionTypeSlug
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param int $startAt
     * @param int $endAt
     * @param string $catalogPromotionId
     * @param string|null $tagId
     */
    public function __construct(
        $name,
        $promotionTypeSlug,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startAt,
        $endAt,
        $catalogPromotionId,
        $tagId = null
    ) {
        $this->catalogPromotionId = Uuid::fromString($catalogPromotionId);
        $this->name = $name;
        $this->promotionTypeSlug = $promotionTypeSlug;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startAt = $startAt;
        $this->endAt = $endAt;

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

    /**
     * @return PromotionType
     */
    public function getPromotionType()
    {
        return PromotionType::createBySlug($this->promotionTypeSlug);
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

    public function getStartAt()
    {
        return $this->startAt;
    }

    public function getEndAt()
    {
        return $this->endAt;
    }

    public function getTagId()
    {
        return $this->tagId;
    }
}
