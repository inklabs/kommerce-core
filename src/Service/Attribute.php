<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class Attribute extends Lib\ServiceManager
{
    /** @var EntityRepository\Attribute */
    private $repository;

    public function __construct(EntityRepository\AttributeInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View\Attribute|null
     */
    public function find($id)
    {
        /** @var Entity\Attribute $attribute */
        $attribute = $this->repository->find($id);

        if ($attribute === null) {
            return null;
        }

        return $attribute->getView()
            ->export();
    }
}
