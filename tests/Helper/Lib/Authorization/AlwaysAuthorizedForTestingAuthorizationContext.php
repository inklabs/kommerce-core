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

    public function verifyCanManageCart(UuidInterface $cartId)
    {
        return;
    }

    public function verifyCanManageUser(UuidInterface $userId)
    {
        return;
    }

    public function verifyCanViewOrder(UuidInterface $orderId)
    {
        return;
    }

    public function verifyIsAdmin()
    {
        return;
    }
}
