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

    public function __construct(string $zip5, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->zip5 = $zip5;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getZip5(): string
    {
        return $this->zip5;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function applyToShipping(): bool
    {
        return $this->applyToShipping;
    }

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
    }
}
