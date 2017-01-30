<?php
namespace inklabs\kommerce\Lib\Authorization;

use inklabs\kommerce\Lib\UuidInterface;

class SessionAuthorizationContext implements AuthorizationContextInterface
{
    /** @var UuidInterface */
    private $userId;

    public function verifyCanMakeRequests()
    {
        return;
    }

    /**
     * @throws AuthorizationContextException
     */
    public function verifyCanManageUser(UuidInterface $userId)
    {
        if (! $this->userId->equals($userId)) {
            throw AuthorizationContextException::userAccessDenied();
        }
    }

    public function verifyIsAdmin()
    {
        // TODO:
        return;
    }
}
