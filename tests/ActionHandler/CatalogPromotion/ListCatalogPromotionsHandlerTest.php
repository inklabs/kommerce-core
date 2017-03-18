<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\ListCatalogPromotionsQuery;
use inklabs\kommerce\ActionResponse\CatalogPromotion\ListCatalogPromotionsResponse;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCatalogPromotionsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CatalogPromotion::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $this->persistEntityAndFlushClear($catalogPromotion);
        $queryString = 'Promotion';
        $query = new ListCatalogPromotionsQuery($queryString, new PaginationDTO());

        /** @var ListCatalogPromotionsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntityInDTOList($catalogPromotion, $response->getCatalogPromotionDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
