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

    public function __construct(
        string $name,
        string $promotionTypeSlug,
        int $value,
        bool $reducesTaxSubtotal,
        int $maxRedemptions,
        int $startAt,
        int $endAt,
        string $catalogPromotionId,
        ?string $tagId = null
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

    public function getCatalogPromotionId(): UuidInterface
    {
        return $this->catalogPromotionId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPromotionType(): PromotionType
    {
        return PromotionType::createBySlug($this->promotionTypeSlug);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getReducesTaxSubtotal(): bool
    {
        return $this->reducesTaxSubtotal;
    }

    public function getMaxRedemptions(): int
    {
        return $this->maxRedemptions;
    }

    public function getStartAt(): int
    {
        return $this->startAt;
    }

    public function getEndAt(): int
    {
        return $this->endAt;
    }

    public function getTagId(): UuidInterface
    {
        return $this->tagId;
    }
}
