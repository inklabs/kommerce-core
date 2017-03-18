<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetAttributeResponse;
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
        $query = new GetAttributeQuery($attribute->getId()->getHex());

        /** @var GetAttributeResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($attribute->getId(), $response->getAttributeDTO()->id);
    }
}
