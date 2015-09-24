<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use Symfony\Component\Validator\Validation;

class AbstractPaymentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $orderItem = new Entity\OrderItem;
        $orderItem->setProduct(new Entity\Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Entity\Price);

        $order = new Entity\Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new Entity\CartTotal);

        /** @var $mock AbstractPayment */
        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Payment\AbstractPayment');
        $mock->setAmount(100);
        $mock->setOrder($order);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($mock));
        $this->assertSame(100, $mock->getAmount());
        $this->assertTrue($mock->getOrder() instanceof Entity\Order);
    }
}
