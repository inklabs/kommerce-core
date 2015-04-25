<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use Doctrine;

class CartPriceRule extends Lib\ServiceManager
{
    /** @var EntityRepository\CartPriceRule */
    private $cartPriceRuleRepository;

    public function __construct(EntityRepository\CartPriceRuleInterface $cartPriceRuleRepository)
    {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    /**
     * @return Entity\CartPriceRule[]
     */
    public function findAll()
    {
        return $this->cartPriceRuleRepository->findAll();
    }
}
