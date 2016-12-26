<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateZip5TaxRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $taxRateId;

    /** @var string */
    private $zip5;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /**
     * @param string $taxRateId
     * @param string $zip5
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($taxRateId, $zip5, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->zip5 = $zip5;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }

    public function getZip5()
    {
        return $this->zip5;
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
