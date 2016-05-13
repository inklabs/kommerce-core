<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Action\Coupon\Query\ListCouponsRequest;
use inklabs\kommerce\Action\Coupon\Query\ListCouponsResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListCouponsQuery implements QueryInterface
{
    /** @var ListCouponsRequest */
    private $request;

    /** @var ListCouponsResponse */
    private $response;

    public function __construct(ListCouponsRequest $request, ListCouponsResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListCouponsRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListCouponsResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
