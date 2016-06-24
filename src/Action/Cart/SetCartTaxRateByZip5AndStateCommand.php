<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetCartTaxRateByZip5AndStateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $zip5;

    /** @var string */
    private $state;

    /**
     * @param string $cartId
     * @param string $zip5
     * @param string $state
     */
    public function __construct($cartId, $zip5, $state)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->zip5 = (string) $zip5;
        $this->state = (string) $state;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    public function getState()
    {
        return $this->state;
    }
}
