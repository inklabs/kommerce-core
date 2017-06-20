<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\EntityDTO\CreditCardDTO;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateOrderFromCartCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $orderId;

    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $ip4;

    /** @var CreditCardDTO */
    private $creditCardDTO;

    /** @var OrderAddressDTO */
    private $shippingAddressDTO;

    /** @var OrderAddressDTO */
    private $billingAddressDTO;

    public function __construct(
        string $cartId,
        string $userId,
        string $ip4,
        CreditCardDTO $creditCardDTO,
        OrderAddressDTO $shippingAddressDTO,
        OrderAddressDTO $billingAddressDTO
    ) {
        $this->orderId = Uuid::uuid4();
        $this->cartId = Uuid::fromString($cartId);
        $this->userId = Uuid::fromString($userId);
        $this->ip4 = $ip4;
        $this->creditCardDTO = $creditCardDTO;
        $this->shippingAddressDTO = $shippingAddressDTO;
        $this->billingAddressDTO = $billingAddressDTO;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getIp4(): string
    {
        return $this->ip4;
    }

    public function getCreditCardDTO(): CreditCardDTO
    {
        return $this->creditCardDTO;
    }

    public function getShippingAddressDTO(): OrderAddressDTO
    {
        return $this->shippingAddressDTO;
    }

    public function getBillingAddressDTO(): OrderAddressDTO
    {
        return $this->billingAddressDTO;
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
