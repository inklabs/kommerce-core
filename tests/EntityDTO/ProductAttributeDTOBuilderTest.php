<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;

class ProductAttributeDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $productAttribute = new ProductAttribute;
        $productAttribute->setProduct(new Product);
        $productAttribute->setAttribute(new Attribute);
        $productAttribute->setAttributeValue(new AttributeValue);

        $productAttributeDTO = $productAttribute->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($productAttributeDTO instanceof ProductAttributeDTO);
        $this->assertTrue($productAttributeDTO->product instanceof ProductDTO);
        $this->assertTrue($productAttributeDTO->attribute instanceof AttributeDTO);
        $this->assertTrue($productAttributeDTO->attributeValue instanceof AttributeValueDTO);
    }
}
