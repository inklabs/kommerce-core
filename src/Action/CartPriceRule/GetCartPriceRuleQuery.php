<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\GetCartPriceRuleResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class GetCartPriceRuleQuery implements QueryInterface
{
    /** @var GetCartPriceRuleRequest */
    private $request;

    /** @var GetCartPriceRuleResponseInterface */
    private $response;

    public function __construct(GetCartPriceRuleRequest $request, GetCartPriceRuleResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetCartPriceRuleRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetCartPriceRuleResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
