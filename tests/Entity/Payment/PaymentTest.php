<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use Symfony\Component\Validator\Validation;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $order = new Entity\Order(new Entity\Cart, new Service\Pricing);

        /* @var $mock Payment */
        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\Payment');
        $mock->setId(1);
        $mock->setAmount(100);
        $mock->addOrder($order);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($mock));
        $this->assertSame(1, $mock->getId());
        $this->assertSame(100, $mock->getAmount());
        $this->assertTrue($mock->getOrder() instanceof Entity\Order);
    }
}
