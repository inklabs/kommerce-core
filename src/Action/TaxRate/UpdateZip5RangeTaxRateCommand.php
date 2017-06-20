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

    public function __construct(string $taxRateId, string $zip5From, string $zip5To, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->zip5From = $zip5From;
        $this->zip5To = $zip5To;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
    }

    public function getZip5From(): string
    {
        return $this->zip5From;
    }

    public function getZip5To(): string
    {
        return $this->zip5To;
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
