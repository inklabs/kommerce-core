<?php
namespace inklabs\kommerce\Lib\Authorization;

class SessionAuthorizationContext implements AuthorizationContextInterface
{
    public function verifyCanMakeRequests()
    {
        return true;
    }
}
