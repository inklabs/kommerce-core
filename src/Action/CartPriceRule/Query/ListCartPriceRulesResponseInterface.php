<?php
namespace inklabs\kommerce\Action\CartPriceRule\Query;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;

interface ListCartPriceRulesResponseInterface
{
    public function addCartPriceRuleDTOBuilder(CartPriceRuleDTOBuilder $couponDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
