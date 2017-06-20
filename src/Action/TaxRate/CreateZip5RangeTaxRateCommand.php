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

    public function __construct(string $zip5From, string $zip5To, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->zip5From = $zip5From;
        $this->zip5To = $zip5To;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
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

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
    }
}
