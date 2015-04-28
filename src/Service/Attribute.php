<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Attribute extends AbstractService
{
    /** @var EntityRepository\Attribute */
    private $attributeRepository;

    public function __construct(EntityRepository\AttributeInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @return View\Attribute|null
     */
    public function find($id)
    {
        /** @var Entity\Attribute $attribute */
        $attribute = $this->attributeRepository->find($id);

        if ($attribute === null) {
            return null;
        }

        return $attribute->getView()
            ->export();
    }
}
