<?php
namespace inklabs\kommerce\Entity\Payment;

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
    }
}
