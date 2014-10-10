<?php
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;

class AttributeTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers Attribute::__construct
	 */
	public function test_construct()
	{
		$attribute = new Attribute;
		$attribute->id = 1;
		$attribute->name = 'Test Attribute';
		$attribute->description = 'Test attribute description';
		$attribute->sort_order = 0;
		$attribute->created = new \DateTime('now', new \DateTimeZone('UTC'));
		$attribute->updated = NULL;

		$this->assertEquals(1, $attribute->id);
	}

	/**
	 * @covers Attribute::add_attribute_value
	 */
	public function test_with_attribute_values()
	{
		$attribute = new Attribute;
		$attribute->id = 1;
		$attribute->name = 'Color';

		$attribute_value_red = new AttributeValue;
		$attribute_value_red->sku = 'RED';
		$attribute_value_red->name = 'Red';

		$attribute_value_green = new AttributeValue;
		$attribute_value_green->sku = 'GRN';
		$attribute_value_green->name = 'Green';

		$attribute_value_blue = new AttributeValue;
		$attribute_value_blue->sku = 'BLU';
		$attribute_value_blue->name = 'Blue';

		$attribute->add_attribute_value($attribute_value_red);
		$attribute->add_attribute_value($attribute_value_green);
		$attribute->add_attribute_value($attribute_value_blue);

		$this->assertEquals(1, $attribute->id);
	}
}
