<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $order = new Entity\Order(new Entity\Cart, new Service\Pricing);

        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\Payment');
        $mock->setId(1);
        $mock->setAmount(100);
        $mock->addOrder($order);

        $this->assertEquals(1, $mock->getId());
        $this->assertEquals(100, $mock->getAmount());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Order', $mock->getOrder());
    }
}
