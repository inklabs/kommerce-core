<?php
namespace inklabs\kommerce\tests\Action\Order;

use inklabs\kommerce\Service\OrderService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;

abstract class AbstractOrderHandlerTestCase extends DoctrineTestCase
{
    /** @var FakeOrderRepository */
    protected $fakeOrderRepository;

    /** @var FakeProductRepository */
    protected $fakeProductRepository;

    /** @var OrderService */
    protected $orderService;

    public function setUp()
    {
        parent::setUp();

        $this->fakeOrderRepository = new FakeOrderRepository;
        $this->fakeProductRepository = new FakeProductRepository;
        $this->orderService = new OrderService(
            $this->fakeOrderRepository,
            $this->fakeProductRepository
        );
    }
}
