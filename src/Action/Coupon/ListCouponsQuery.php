<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Action\Coupon\Query\ListCouponsRequest;
use inklabs\kommerce\Action\Coupon\Query\ListCouponsResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListCouponsQuery implements QueryInterface
{
    /** @var ListCouponsRequest */
    private $request;

    /** @var ListCouponsResponseInterface */
    private $response;

    public function __construct(ListCouponsRequest $request, ListCouponsResponseInterface & $response)
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
     * @return ListCouponsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
