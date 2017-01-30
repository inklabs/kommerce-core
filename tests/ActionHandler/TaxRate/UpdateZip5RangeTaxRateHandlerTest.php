<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5RangeTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateZip5RangeTaxRateHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $taxRate = $this->dummyData->getStateTaxRate();
        $this->persistEntityAndFlushClear($taxRate);
        $applyToShipping = true;
        $zip5From = self::ZIP5;
        $zip5To = self::ZIP5;
        $rate = self::FLOAT_TAX_RATE;
        $command = new UpdateZip5RangeTaxRateCommand(
            $taxRate->getId()->getHex(),
            $zip5From,
            $zip5To,
            $rate,
            $applyToShipping
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $taxRate = $this->getRepositoryFactory()->getTaxRateRepository()->findOneById(
            $command->getTaxRateId()
        );
        $this->assertSame(null, $taxRate->getZip5());
        $this->assertSame(null, $taxRate->getState());
        $this->assertSame($zip5From, $taxRate->getZip5From());
        $this->assertSame($zip5To, $taxRate->getZip5To());
        $this->assertFloatEquals($rate, $taxRate->getRate());
        $this->assertSame($applyToShipping, $taxRate->getApplyToShipping());
    }
}
