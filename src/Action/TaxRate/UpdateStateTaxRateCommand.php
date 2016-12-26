<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateStateTaxRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $taxRateId;

    /** @var string */
    private $state;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /**
     * @param string $taxRateId
     * @param string $state
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($taxRateId, $state, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->state = $state;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function applyToShipping()
    {
        return $this->applyToShipping;
    }
}
