<?php
namespace inklabs\kommerce\tests\Helper\Lib\Authorization;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\UuidInterface;

class AlwaysAuthorizedForTestingAuthorizationContext implements AuthorizationContextInterface
{
    public function verifyCanMakeRequests()
    {
        return;
    }

    public function verifyCanManageUser(UuidInterface $userId)
    {
        return true;
    }

    public function verifyIsAdmin()
    {
        return true;
    }
}
