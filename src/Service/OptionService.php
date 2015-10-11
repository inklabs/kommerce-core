<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;

class OptionService extends AbstractService
{
    /** @var OptionRepositoryInterface */
    private $optionRepository;

    public function __construct(OptionRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function create(Option & $option)
    {
        $this->throwValidationErrors($option);
        $this->optionRepository->create($option);
    }

    public function edit(Option & $option)
    {
        $this->throwValidationErrors($option);
        $this->optionRepository->save($option);
    }

    /**
     * @param int $id
     * @return Option|null
     */
    public function findOneById($id)
    {
        $option = $this->optionRepository->findOneById($id);
        return $option;
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptions($queryString = null, Pagination & $pagination = null)
    {
        $options = $this->optionRepository->getAllOptions($queryString, $pagination);
        return $options;
    }
}
