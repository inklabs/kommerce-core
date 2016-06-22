<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Action\User\Query\ListUsersRequest;
use inklabs\kommerce\Action\User\Query\ListUsersResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class ListUsersQuery implements QueryInterface
{
    /** @var ListUsersRequest */
    private $request;

    /** @var ListUsersResponseInterface */
    private $response;

    public function __construct(ListUsersRequest $request, ListUsersResponseInterface & $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ListUsersRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ListUsersResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
