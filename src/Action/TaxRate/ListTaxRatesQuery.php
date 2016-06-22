<?php
namespace inklabs\kommerce\Action\TaxRate;

use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesRequest;
use inklabs\kommerce\Action\TaxRate\Query\ListTaxRatesResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListTaxRatesQuery implements QueryInterface
{
    /** @var ListTaxRatesRequest */
    private $request;

    /** @var ListTaxRatesResponseInterface */
    private $response;

    public function __construct(ListTaxRatesRequest $request, ListTaxRatesResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListTaxRatesRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListTaxRatesResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
