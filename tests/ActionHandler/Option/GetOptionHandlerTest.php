<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\GetOptionQuery;
use inklabs\kommerce\Action\Option\Query\GetOptionRequest;
use inklabs\kommerce\Action\Option\Query\GetOptionResponse;
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
        $request = new GetOptionRequest($option->getId()->getHex());
        $response = new GetOptionResponse($this->getPricing());
        $query = new GetOptionQuery($request, $response);

        $this->dispatchQuery($query);
        $this->assertEquals($option->getId(), $response->getOptionDTO()->id);

        $this->dispatchQuery($query);
        $this->assertEquals($option->getId(), $response->getOptionDTOWithAllData()->id);
    }
}
