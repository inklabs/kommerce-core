<?php
namespace inklabs\kommerce\Lib\Authorization;

use inklabs\kommerce\Lib\UuidInterface;

interface AuthorizationContextInterface
{
    public function verifyCanMakeRequests(): void;
    public function verifyCanManageCart(UuidInterface $cartId): void;
    public function verifyCanManageUser(UuidInterface $userId): void;
    public function verifyIsAdmin(): void;
    public function verifyCanViewOrder(UuidInterface $orderId): void;
}
