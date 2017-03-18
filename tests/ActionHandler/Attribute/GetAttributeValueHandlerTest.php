<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeValueQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetAttributeValueResponse;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetAttributeValueHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);
        $this->persistEntityAndFlushClear([$attribute, $attributeValue]);
        $query = new GetAttributeValueQuery($attributeValue->getId()->getHex());

        /** @var GetAttributeValueResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($attributeValue->getId(), $response->getAttributeValueDTO()->id);
    }
}
