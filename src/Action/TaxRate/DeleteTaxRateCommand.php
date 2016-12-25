<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteTaxRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $taxRateId;

    /**
     * @param string $taxRateId
     */
    public function __construct($taxRateId)
    {
        $this->taxRateId = Uuid::fromString($taxRateId);
    }

    public function getTaxRateId()
    {
        return $this->taxRateId;
    }
}
