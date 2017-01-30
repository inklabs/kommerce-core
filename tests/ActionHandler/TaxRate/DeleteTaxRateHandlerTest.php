<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\DeleteTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteTaxRateHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $taxRate = $this->dummyData->getStateTaxRate();
        $this->persistEntityAndFlushClear($taxRate);
        $command = new DeleteTaxRateCommand($taxRate->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->setExpectedException(EntityNotFoundException::class);
        $taxRate = $this->getRepositoryFactory()->getTaxRateRepository()->findOneById(
            $command->getTaxRateId()
        );
    }
}
