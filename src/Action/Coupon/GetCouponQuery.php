<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Action\Coupon\Query\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Query\GetCouponResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCouponQuery implements QueryInterface
{
    /** @var GetCouponRequest */
    private $request;

    /** @var GetCouponResponseInterface */
    private $response;

    public function __construct(GetCouponRequest $request, GetCouponResponseInterface & $response)
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
     * @return GetCouponResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
