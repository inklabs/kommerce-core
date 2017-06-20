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

    public function __construct(string $taxRateId, string $zip5, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->zip5 = $zip5;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
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
}
