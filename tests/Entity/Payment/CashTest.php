<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CashTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $payment = new Cash(100);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($payment));
        $this->assertSame(100, $payment->getAmount());
        $this->assertTrue($payment->getView() instanceof View\Payment\Cash);
    }
}
