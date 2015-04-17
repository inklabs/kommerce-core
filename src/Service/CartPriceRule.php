<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use Doctrine;

class CartPriceRule extends Lib\ServiceManager
{
    /** @var EntityRepository\CartPriceRule */
    private $repository;

    public function __construct(EntityRepository\CartPriceRuleInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Entity\CartPriceRule[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
