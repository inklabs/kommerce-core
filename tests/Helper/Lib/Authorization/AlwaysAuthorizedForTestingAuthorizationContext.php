<?php
namespace inklabs\kommerce\tests\Helper\Lib\Authorization;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\UuidInterface;

class AlwaysAuthorizedForTestingAuthorizationContext implements AuthorizationContextInterface
{
    public function verifyCanMakeRequests(): void
    {
        return;
    }

    public function verifyCanManageCart(UuidInterface $cartId): void
    {
        return;
    }

    public function verifyCanManageUser(UuidInterface $userId): void
    {
        return;
    }

    public function verifyCanViewOrder(UuidInterface $orderId): void
    {
        return;
    }

    public function verifyIsAdmin(): void
    {
        return;
    }
}
