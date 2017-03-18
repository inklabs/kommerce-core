<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\ActionResponse\Option\GetOptionResponse;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetOptionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionProduct::class,
        OptionValue::class,
        Product::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $option = $this->dummyData->getOption();
        $this->persistEntityAndFlushClear($option);
        $query = new GetOptionQuery($option->getId()->getHex());

        /** @var GetOptionResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertEquals($option->getId(), $response->getOptionDTO()->id);

        $response = $this->dispatchQuery($query);
        $this->assertEquals($option->getId(), $response->getOptionDTOWithAllData()->id);
    }
}
