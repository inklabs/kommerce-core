<?php
namespace inklabs\kommerce\tests\Helper\Lib\Authorization;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;

class AlwaysAuthorizedForTestingAuthorizationContext implements AuthorizationContextInterface
{
    public function verifyCanMakeRequests()
    {
        return;
    }
}
