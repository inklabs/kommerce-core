<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class CartPriceRule extends AbstractService
{
    /** @var EntityRepository\CartPriceRule */
    private $cartPriceRuleRepository;

    public function __construct(EntityRepository\CartPriceRuleInterface $cartPriceRuleRepository)
    {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    public function create(Entity\CartPriceRule & $cartPriceRule)
    {
        $this->throwValidationErrors($cartPriceRule);
        $this->cartPriceRuleRepository->create($cartPriceRule);
    }

    public function edit(Entity\CartPriceRule & $cartPriceRule)
    {
        $this->throwValidationErrors($cartPriceRule);
        $this->cartPriceRuleRepository->save($cartPriceRule);
    }

    /**
     * @param int $id
     * @return Entity\CartPriceRule
     */
    public function find($id)
    {
        return $this->cartPriceRuleRepository->find($id);
    }

    /**
     * @return Entity\CartPriceRule[]
     */
    public function findAll()
    {
        return $this->cartPriceRuleRepository->findAll();
    }
}
