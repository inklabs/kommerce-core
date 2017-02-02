<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\GetCatalogPromotionQuery;
use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionRequest;
use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionResponse;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCatalogPromotionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CatalogPromotion::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $this->persistEntityAndFlushClear($catalogPromotion);
        $request = new GetCatalogPromotionRequest(
            $catalogPromotion->getId()->getHex()
        );
        $response = new GetCatalogPromotionResponse();
        $query = new GetCatalogPromotionQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($catalogPromotion->getId(), $response->getCatalogPromotionDTO()->id);
    }
}
