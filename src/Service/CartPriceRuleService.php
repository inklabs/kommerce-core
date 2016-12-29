<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

class CartPriceRuleService implements CartPriceRuleServiceInterface
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
        $this->cartPriceRuleRepository->create($cartPriceRule);
    }

    public function update(CartPriceRule & $cartPriceRule)
    {
        $this->cartPriceRuleRepository->update($cartPriceRule);
    }

    public function delete(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRuleRepository->delete($cartPriceRule);
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

    /**
     * @param null|string $queryString
     * @param null|Pagination $pagination
     * @return CartPriceRule[]
     */
    public function getAllCartPriceRules($queryString = null, Pagination & $pagination = null)
    {
        return $this->cartPriceRuleRepository->getAllCartPricerules($queryString, $pagination);
    }
}
