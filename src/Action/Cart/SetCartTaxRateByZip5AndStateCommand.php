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

    public function __construct(string $cartId, string $zip5, string $state)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->zip5 = $zip5;
        $this->state = $state;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getZip5(): string
    {
        return $this->zip5;
    }

    public function getState(): string
    {
        return $this->state;
    }
}
