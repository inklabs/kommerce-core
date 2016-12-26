<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use DateTime;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartPriceRuleCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartPriceRuleId;

    /** @var string */
    private $name;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int */
    private $maxRedemptions;

    /** @var DateTime */
    private $startDate;

    /** @var DateTime */
    private $endDate;

    /**
     * CreateCartPriceRuleCommand constructor.
     * @param string $name
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param DateTime $startDate
     * @param DateTime $endDate
     */
    public function __construct(
        $name,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startDate,
        $endDate
    ) {
        $this->cartPriceRuleId = Uuid::uuid4();
        $this->name = $name;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCartPriceRuleId()
    {
        return $this->cartPriceRuleId;
    }

    public function getName()
    {
        return $this->name;
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
}
