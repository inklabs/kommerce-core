<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\Query\ListCatalogPromotionsRequest;
use inklabs\kommerce\Action\CatalogPromotion\Query\ListCatalogPromotionsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListCatalogPromotionsQuery implements QueryInterface
{
    /** @var ListCatalogPromotionsRequest */
    private $request;

    /** @var ListCatalogPromotionsResponseInterface */
    private $response;

    public function __construct(
        ListCatalogPromotionsRequest $request,
        ListCatalogPromotionsResponseInterface & $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListCatalogPromotionsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListCatalogPromotionsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
