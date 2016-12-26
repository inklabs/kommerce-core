<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateZip5RangeTaxRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $taxRateId;

    /** @var string */
    private $zip5From;

    /** @var string */
    private $zip5To;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /**
     * @param string $taxRateId
     * @param string $zip5From
     * @param string $zip5To
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($taxRateId, $zip5From, $zip5To, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->zip5From = $zip5From;
        $this->zip5To = $zip5To;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }

    public function getZip5From()
    {
        return $this->zip5From;
    }

    public function getZip5To()
    {
        return $this->zip5To;
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
