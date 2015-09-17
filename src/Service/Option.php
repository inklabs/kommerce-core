<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib;

class Option extends AbstractService
{
    /** @var OptionRepositoryInterface */
    private $optionRepository;

    public function __construct(OptionRepositoryInterface $optionRepository)
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
