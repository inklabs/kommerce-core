<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;

class AttributeValueDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $productAttribute = new ProductAttribute;
        $productAttribute->setProduct(new Product);

        $attributeValue = new AttributeValue;
        $attributeValue->setAttribute(new Attribute);
        $attributeValue->addProductAttribute($productAttribute);

        $attributeValueDTO = $attributeValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($attributeValueDTO instanceof AttributeValueDTO);
        $this->assertTrue($attributeValueDTO->attribute instanceof AttributeDTO);
        $this->assertTrue($attributeValueDTO->productAttributes[0] instanceof ProductAttributeDTO);
        $this->assertTrue($attributeValueDTO->productAttributes[0]->product instanceof ProductDTO);
    }
}
