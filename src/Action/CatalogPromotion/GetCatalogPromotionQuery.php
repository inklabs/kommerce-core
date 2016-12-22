<?php
namespace inklabs\kommerce\Action\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionRequest;
use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCatalogPromotionQuery implements QueryInterface
{
    /** @var GetCatalogPromotionRequest */
    private $request;

    /** @var GetCatalogPromotionResponseInterface */
    private $response;

    public function __construct(GetCatalogPromotionRequest $request, GetCatalogPromotionResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCatalogPromotionRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCatalogPromotionResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
