<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5TaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateZip5TaxRateHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $taxRate = $this->dummyData->getStateTaxRate();
        $this->persistEntityAndFlushClear($taxRate);
        $applyToShipping = true;
        $zip5 = self::ZIP5;
        $rate = self::FLOAT_TAX_RATE;
        $command = new UpdateZip5TaxRateCommand(
            $taxRate->getId()->getHex(),
            $zip5,
            $rate,
            $applyToShipping
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $taxRate = $this->getRepositoryFactory()->getTaxRateRepository()->findOneById(
            $command->getTaxRateId()
        );
        $this->assertSame(null, $taxRate->getState());
        $this->assertSame(null, $taxRate->getZip5From());
        $this->assertSame(null, $taxRate->getZip5To());
        $this->assertSame($zip5, $taxRate->getZip5());
        $this->assertFloatEquals($rate, $taxRate->getRate());
        $this->assertSame($applyToShipping, $taxRate->getApplyToShipping());
    }
}
