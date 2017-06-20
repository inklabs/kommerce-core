<?php
namespace inklabs\kommerce\ActionResponse\CartPriceRule;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListCartPriceRulesResponse implements ResponseInterface
{
    /** @var CartPriceRuleDTOBuilder[] */
    protected $couponDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addCartPriceRuleDTOBuilder(CartPriceRuleDTOBuilder $couponDTOBuilder): void
    {
        $this->couponDTOBuilders[] = $couponDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return CartPriceRuleDTO[]
     */
    public function getCartPriceRuleDTOs(): array
    {
        $couponDTOs = [];
        foreach ($this->couponDTOBuilders as $couponDTOBuilder) {
            $couponDTOs[] = $couponDTOBuilder->build();
        }
        return $couponDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
