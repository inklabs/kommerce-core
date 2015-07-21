<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Option extends AbstractService
{
    /** @var EntityRepository\OptionInterface */
    private $optionRepository;

    public function __construct(EntityRepository\OptionInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function create(Entity\Option & $option)
    {
        $this->throwValidationErrors($option);
        $this->optionRepository->create($option);
    }

    public function edit(Entity\Option & $option)
    {
        $this->throwValidationErrors($option);
        $this->optionRepository->save($option);
    }

    /**
     * @param int $id
     * @return Entity\Option|null
     */
    public function find($id)
    {
        $option = $this->optionRepository->find($id);
        return $option;
    }

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Option[]
     */
    public function getAllOptions($queryString = null, Entity\Pagination & $pagination = null)
    {
        $options = $this->optionRepository->getAllOptions($queryString, $pagination);
        return $options;
    }
}
