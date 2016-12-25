<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateZip5TaxRateCommand implements CommandInterface
{
    /** @var string */
    private $zip5;

    /** @var float */
    private $rate;

    /** @var bool */
    private $applyToShipping;

    /** @var UuidInterface */
    private $taxRateId;

    /**
     * @param string $zip5
     * @param float $rate
     * @param bool $applyToShipping
     */
    public function __construct($zip5, $rate, $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->zip5 = $zip5;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
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

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }
}
