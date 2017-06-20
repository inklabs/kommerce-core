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

    public function __construct(string $state, float $rate, bool $applyToShipping)
    {
        $this->taxRateId = Uuid::uuid4();
        $this->state = $state;
        $this->rate = $rate;
        $this->applyToShipping = $applyToShipping;
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

    public function getTaxRateId(): UuidInterface
    {
        return $this->taxRateId;
    }
}
