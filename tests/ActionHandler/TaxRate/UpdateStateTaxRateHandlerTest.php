<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateStateTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateStateTaxRateHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $taxRate = $this->dummyData->getStateTaxRate();
        $this->persistEntityAndFlushClear($taxRate);
        $applyToShipping = true;
        $state = self::STATE;
        $rate = self::FLOAT_TAX_RATE;
        $command = new UpdateStateTaxRateCommand(
            $taxRate->getId()->getHex(),
            $state,
            $rate,
            $applyToShipping
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $taxRate = $this->getRepositoryFactory()->getTaxRateRepository()->findOneById(
            $command->getTaxRateId()
        );
        $this->assertSame(null, $taxRate->getZip5());
        $this->assertSame(null, $taxRate->getZip5From());
        $this->assertSame(null, $taxRate->getZip5To());
        $this->assertSame(null, $taxRate->getZip5());
        $this->assertSame($state, $taxRate->getState());
        $this->assertFloatEquals($rate, $taxRate->getRate());
        $this->assertSame($applyToShipping, $taxRate->getApplyToShipping());
    }
}
