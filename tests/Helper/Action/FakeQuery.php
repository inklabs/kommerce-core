<?php
namespace inklabs\kommerce\tests\Helper\Action;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\tests\Helper\Action\Query\FakeRequest;
use inklabs\kommerce\tests\Helper\Action\Query\FakeResponse;

final class FakeQuery implements QueryInterface
{
    public function __construct(FakeRequest $request, FakeResponse & $response)
    {
    }
}
