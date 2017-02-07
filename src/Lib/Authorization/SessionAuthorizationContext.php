<?php
namespace inklabs\kommerce\Lib\Authorization;

use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Lib\UuidInterface;

class SessionAuthorizationContext implements AuthorizationContextInterface
{
    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var null|UuidInterface */
    private $userId;

    /** @var null|string */
    private $sessionId;

    /** @var bool */
    private $isAdmin;

    /**
     * @param CartRepositoryInterface $cartRepository
     * @param OrderRepositoryInterface $orderRepository
     * @param null|string $sessionId
     * @param UuidInterface $userId
     * @param bool $isAdmin
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        OrderRepositoryInterface $orderRepository,
        $sessionId = null,
        UuidInterface $userId = null,
        $isAdmin = false
    ) {
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
        $this->sessionId = $sessionId;
        $this->userId = $userId;
        $this->isAdmin = $isAdmin;
    }

    public function verifyCanMakeRequests()
    {
        return;
    }

    public function verifyCanManageCart(UuidInterface $cartId)
    {
        $cart = $this->cartRepository->findOneById(
            $cartId
        );
        $cartUser = $cart->getUser();
        $cartSessionId = $cart->getSessionId();

        if ($this->userId !== null && $cartUser !== null && $this->userId->equals($cart->getUser()->getId())) {
            return;
        }

        if ($this->sessionId !== null && $cartSessionId !== null && $this->sessionId === $cartSessionId) {
            return;
        }

        if (! $this->isAdmin()) {
            throw AuthorizationContextException::cartAccessDenied();
        }
    }

    public function verifyCanManageUser(UuidInterface $userId)
    {
        if ($this->userId !== null && $this->userId->equals($userId)) {
            return;
        }

        if (! $this->isAdmin()) {
            throw AuthorizationContextException::userAccessDenied();
        }
    }

    public function verifyIsAdmin()
    {
        if (! $this->isAdmin()) {
            throw AuthorizationContextException::accessDenied();
        }

    }

    public function verifyCanViewOrder(UuidInterface $orderId)
    {
        $order = $this->orderRepository->findOneById($orderId);

        if ($this->userId !== null && $this->userId->equals($order->getUser()->getId())) {
            return;
        }

        if (! $this->isAdmin()) {
            throw AuthorizationContextException::accessDenied();
        }
    }

    private function isAdmin()
    {
        return $this->isAdmin;
    }
}
