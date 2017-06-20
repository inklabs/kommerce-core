<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractCartPriceRuleCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $name;

    /** @var int */
    private $maxRedemptions;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int */
    private $startAt;

    /** @var int */
    private $endAt;

    public function __construct(
        string $name,
        int $maxRedemptions,
        bool $reducesTaxSubtotal,
        int $startAt,
        int $endAt,
        string $cartPriceRuleId
    ) {
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->name = $name;
        $this->maxRedemptions = $maxRedemptions;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function getCartPriceRuleId(): UuidInterface
    {
        return $this->cartPriceRuleId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxRedemptions(): int
    {
        return $this->maxRedemptions;
    }

    public function getReducesTaxSubtotal(): bool
    {
        return $this->reducesTaxSubtotal;
    }

    public function getStartAt(): int
    {
        return $this->startAt;
    }

    public function getEndAt(): int
    {
        return $this->endAt;
    }
}
