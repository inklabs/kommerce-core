<?php
namespace inklabs\kommerce\ActionResponse\Cart;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCartResponse implements ResponseInterface
{
    /** @var CartDTOBuilder */
    private $cartDTOBuilder;

    /** @var CartCalculator */
    private $cartCalculator;

    public function __construct(CartCalculator $cartCalculator)
    {
        $this->cartCalculator = $cartCalculator;
    }

    public function setCartDTOBuilder(CartDTOBuilder $cartDTOBuilder): void
    {
        $this->cartDTOBuilder = $cartDTOBuilder;
    }

    public function getCartDTO(): CartDTO
    {
        return $this->cartDTOBuilder
            ->build();
    }

    public function getCartDTOWithAllData(): CartDTO
    {
        return $this->cartDTOBuilder
            ->withAllData($this->cartCalculator)
            ->build();
    }
}
