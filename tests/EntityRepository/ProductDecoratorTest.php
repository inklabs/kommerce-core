<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;
use inklabs\kommerce\tests\EntityRepository\ProductInterfaceTest;

class ProductDecoratorTest extends ProductInterfaceTest
{
    public function setUp()
    {
        $this->productRepository = new ProductDecorator(new FakeProduct);
    }
}
