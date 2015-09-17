<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

class CartPriceRule extends AbstractService
{
    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    public function __construct(CartPriceRuleRepositoryInterface $cartPriceRuleRepository)
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
