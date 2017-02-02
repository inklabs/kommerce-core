<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeQuery;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeRequest;
use inklabs\kommerce\Action\Attribute\Query\GetAttributeResponse;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetAttributeHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
    ];

    public function testHandle()
    {
        $attribute = $this->dummyData->getAttribute();
        $this->persistEntityAndFlushClear($attribute);
        $request = new GetAttributeRequest($attribute->getId()->getHex());
        $response = new GetAttributeResponse();

        $this->dispatchQuery(new GetAttributeQuery($request, $response));

        $this->assertEquals($attribute->getId(), $response->getAttributeDTO()->id);
    }
}
