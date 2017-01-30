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
     * @param UuidInterface $userId
     * @throws AuthorizationContextException
     */
    public function verifyCanManageUser(UuidInterface $userId);

    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAdmin();
}
