<?php
namespace inklabs\kommerce\Lib\Authorization;

use inklabs\kommerce\Lib\UuidInterface;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyCanMakeRequests();

    /**
     * @throws AuthorizationContextException
     */
    public function verifyCanManageUser(UuidInterface $userId);
}
