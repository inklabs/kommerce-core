<?php
namespace inklabs\kommerce\Action\CartPriceRule;

use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class UpdateCartPriceRuleCommand implements CommandInterface
{
    /** @var CartPriceRuleDTO */
    private $cartPriceRuleDTO;

    public function __construct(CartPriceRuleDTO $cartPriceRuleDTO)
    {
        $this->cartPriceRuleDTO = $cartPriceRuleDTO;
    }

    public function getCartPriceRuleDTO()
    {
        return $this->cartPriceRuleDTO;
    }
}
