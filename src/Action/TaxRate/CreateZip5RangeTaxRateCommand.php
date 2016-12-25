<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateZip5RangeTaxRateCommand implements CommandInterface
{
    /** @var string */
    private $zip5From;

    /** @var string */
    private $zip5To;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /** @var UuidInterface */
    private $taxRateId;

    /**
     * @param string $zip5From
     * @param string $zip5To
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($zip5From, $zip5To, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->zip5From = $zip5From;
        $this->zip5To = $zip5To;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
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

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }
}
