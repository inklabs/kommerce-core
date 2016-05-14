<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\CreditCardDTO;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;

final class CreateOrderFromCartRequest
{
    /** @var int */
    private $cartId;

    /** @var string */
    private $ip4;

    /** @var CreditCardDTO */
    private $creditCardDTO;

    /** @var OrderAddressDTO */
    private $shippingAddressDTO;

    /** @var OrderAddressDTO */
    private $billingAddressDTO;

    public function __construct(
        $cartId,
        $ip4,
        CreditCardDTO $creditCardDTO,
        OrderAddressDTO $shippingAddressDTO,
        OrderAddressDTO $billingAddressDTO
    ) {
        $this->cartId = $cartId;
        $this->ip4 = $ip4;
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
}
