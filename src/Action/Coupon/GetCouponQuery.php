<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Action\Coupon\Query\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Query\GetCouponResponse;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCouponQuery implements QueryInterface
{
    /** @var GetCouponRequest */
    private $request;

    /** @var \inklabs\kommerce\Action\Coupon\Query\GetCouponResponse */
    private $response;

    public function __construct(GetCouponRequest $request, GetCouponResponse & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCouponRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCouponResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
