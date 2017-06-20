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

    public function __construct(string $taxRateId, string $state, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
        $this->state = $state;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
    }

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
    }

    public function getState(): string
    {
        return $this->state;
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
