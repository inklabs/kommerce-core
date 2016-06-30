<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartPriceRuleRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class CartPriceRuleServiceTest extends ServiceTestCase
{
    /** @var CartPriceRuleRepositoryInterface | \Mockery\Mock */
    protected $cartPriceRuleRepository;

    /** @var CartPriceRuleService */
    protected $cartPriceRuleService;

    public function setUp()
    {
        parent::setUp();
        $this->cartPriceRuleRepository = $this->mockRepository->getCartPriceRuleRepository();
        $this->cartPriceRuleService = new CartPriceRuleService($this->cartPriceRuleRepository);
    }

    public function testFind()
    {
        $cartPriceRule1 = $this->dummyData->getCartPriceRule();
        $this->cartPriceRuleRepository->shouldReceive('findOneById')
            ->andReturn($cartPriceRule1)
            ->once();

        $cartPriceRule = $this->cartPriceRuleService->findOneById(
            $cartPriceRule1->getId()
        );

        $this->assertEntitiesEqual($cartPriceRule1, $cartPriceRule);
    }

    public function testFindAll()
    {
        $cartPriceRule1 = $this->dummyData->getCartPriceRule();
        $this->cartPriceRuleRepository->shouldReceive('findAll')
            ->andReturn([$cartPriceRule1])
            ->once();

        $cartPriceRules = $this->cartPriceRuleService->findAll();

        $this->assertEntitiesEqual($cartPriceRule1, $cartPriceRules[0]);
    }
}
