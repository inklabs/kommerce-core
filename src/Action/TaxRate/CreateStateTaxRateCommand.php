<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateStateTaxRateCommand implements CommandInterface
{
    /** @var string */
    private $state;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /** @var UuidInterface */
    private $taxRateId;

    /**
     * @param string $state
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($state, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->state = $state;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
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

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }
}
