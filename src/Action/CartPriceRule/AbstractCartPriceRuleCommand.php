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

    /**
     * @param string$name
     * @param int $maxRedemptions
     * @param bool $reducesTaxSubtotal
     * @param int $startAt
     * @param int $endAt
     * @param string $cartPriceRuleId
     */
    public function __construct(
        $name,
        $maxRedemptions,
        $reducesTaxSubtotal,
        $startAt,
        $endAt,
        $cartPriceRuleId
    ) {
        $this->cartPriceRuleId = Uuid::fromString($cartPriceRuleId);
        $this->name = $name;
        $this->maxRedemptions = $maxRedemptions;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function getCartPriceRuleId()
    {
        return $this->cartPriceRuleId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMaxRedemptions()
    {
        return $this->maxRedemptions;
    }

    public function getReducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function getStartAt()
    {
        return $this->startAt;
    }

    public function getEndAt()
    {
        return $this->endAt;
    }
}
