<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateStateTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateStateTaxRateHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    public function testHandle()
    {
        $applyToShipping = true;
        $command = new CreateStateTaxRateCommand(
            self::STATE,
            self::FLOAT_TAX_RATE,
            $applyToShipping
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $taxRate = $this->getRepositoryFactory()->getTaxRateRepository()->findOneById(
            $command->getTaxRateId()
        );
        $this->assertSame(self::STATE, $taxRate->getState());
        $this->assertFloatEquals(self::FLOAT_TAX_RATE, $taxRate->getRate());
        $this->assertSame($applyToShipping, $taxRate->getApplyToShipping());
    }
}
