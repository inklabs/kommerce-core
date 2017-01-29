<?php
namespace inklabs\kommerce\Lib\Authorization;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyCanMakeRequests();
}
