<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesRequest;
use inklabs\kommerce\Action\CartPriceRule\Query\ListCartPriceRulesResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

class ListCartPriceRulesQuery implements QueryInterface
{
    /** @var ListCartPriceRulesRequest */
    private $request;

    /** @var ListCartPriceRulesResponseInterface */
    private $response;

    public function __construct(ListCartPriceRulesRequest $request, ListCartPriceRulesResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListCartPriceRulesRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListCartPriceRulesResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
