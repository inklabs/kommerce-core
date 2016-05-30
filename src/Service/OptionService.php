<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class OptionService
{
    use EntityValidationTrait;

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

    public function update(Option & $option)
    {
        $this->throwValidationErrors($option);
        $this->optionRepository->update($option);
    }

    /**
     * @param UuidInterface $id
     * @return Option
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
    {
        return $this->optionRepository->findOneById($id);
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
