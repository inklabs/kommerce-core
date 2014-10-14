<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\VirtualProduct;

class VirtualProductTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $virtual_product = new VirtualProduct;
        $virtual_product->id = 1;
        $virtual_product->sku = 'TST101';
        $virtual_product->name = 'Test Product';
        $virtual_product->price = 500;
        $virtual_product->quantity = 10;
        $virtual_product->product_group_id = null;
        $virtual_product->require_inventory = true;
        $virtual_product->show_price = true;
        $virtual_product->active = true;
        $virtual_product->visible = true;
        $virtual_product->is_taxable = true;
        $virtual_product->shipping = true;
        $virtual_product->shipping_weight = 16;
        $virtual_product->description = 'Test product description';
        $virtual_product->rating = null;
        $virtual_product->default_image = null;
        $virtual_product->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $virtual_product->updated = null;

        $this->assertEquals(1, $virtual_product->id);
    }
}
