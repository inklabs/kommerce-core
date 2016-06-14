<?php
namespace inklabs\kommerce\tests\Helper\Action;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\tests\Helper\Action\Query\FakeRequest;
use inklabs\kommerce\tests\Helper\Action\Query\FakeResponseInterface;

final class FakeQuery implements QueryInterface
{
    /** @var FakeRequest */
    private $request;

    /** @var FakeResponseInterface */
    private $response;

    public function __construct(FakeRequest $request, FakeResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
