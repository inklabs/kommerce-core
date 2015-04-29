<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionProduct = new Entity\OptionProduct;
        $optionProduct->setOption(new Entity\Option);
        $optionProduct->setProduct(new Entity\Product);

        $viewOptionProduct = $optionProduct->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewOptionProduct instanceof OptionProduct);
        $this->assertTrue($viewOptionProduct->option instanceof Option);
    }
}
