<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class CashPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $payment = new CashPayment(100);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($payment));
        $this->assertSame(100, $payment->getAmount());
    }
}
