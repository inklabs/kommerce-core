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

    /**
     * @param string $cartId
     * @param string $userId
     * @param string $ip4
     * @param CreditCardDTO $creditCardDTO
     * @param OrderAddressDTO $shippingAddressDTO
     * @param OrderAddressDTO $billingAddressDTO
     */
    public function __construct(
        $cartId,
        $userId,
        $ip4,
        CreditCardDTO $creditCardDTO,
        OrderAddressDTO $shippingAddressDTO,
        OrderAddressDTO $billingAddressDTO
    ) {
        $this->orderId = Uuid::uuid4();
        $this->cartId = Uuid::fromString($cartId);
        $this->userId = Uuid::fromString($userId);
        $this->ip4 = (string) $ip4;
        $this->creditCardDTO = $creditCardDTO;
        $this->shippingAddressDTO = $shippingAddressDTO;
        $this->billingAddressDTO = $billingAddressDTO;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getIp4()
    {
        return $this->ip4;
    }

    public function getCreditCardDTO()
    {
        return $this->creditCardDTO;
    }

    public function getShippingAddressDTO()
    {
        return $this->shippingAddressDTO;
    }

    public function getBillingAddressDTO()
    {
        return $this->billingAddressDTO;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
