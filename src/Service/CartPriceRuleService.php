<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

class CartPriceRuleService
{
    use EntityValidationTrait;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    public function __construct(CartPriceRuleRepositoryInterface $cartPriceRuleRepository)
    {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    public function create(CartPriceRule & $cartPriceRule)
    {
        $this->throwValidationErrors($cartPriceRule);
        $this->cartPriceRuleRepository->create($cartPriceRule);
    }

    public function edit(CartPriceRule & $cartPriceRule)
    {
        $this->throwValidationErrors($cartPriceRule);
        $this->cartPriceRuleRepository->update($cartPriceRule);
    }

    /**
     * @param UuidInterface $id
     * @return CartPriceRule
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
    {
        return $this->cartPriceRuleRepository->findOneById($id);
    }

    /**
     * @return CartPriceRule[]
     */
    public function findAll()
    {
        return $this->cartPriceRuleRepository->findAll();
    }
}
