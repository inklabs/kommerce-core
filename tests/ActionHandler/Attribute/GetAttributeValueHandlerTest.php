<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeValueQuery;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeValueRequest;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeValueResponse;
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
        $request = new GetAttributeValueRequest($attributeValue->getId()->getHex());
        $response = new GetAttributeValueResponse();

        $this->dispatchQuery(new GetAttributeValueQuery($request, $response));

        $this->assertEquals($attributeValue->getId(), $response->getAttributeValueDTO()->id);
    }
}
