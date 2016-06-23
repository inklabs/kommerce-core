<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\Lib\UuidInterface;

class OptionService implements OptionServiceInterface
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

    public function createOptionValue(OptionValue & $optionValue)
    {
        $this->throwValidationErrors($optionValue);
        $this->optionRepository->create($optionValue);
    }

    public function updateOptionValue(OptionValue & $optionValue)
    {
        $this->throwValidationErrors($optionValue);
        $this->optionRepository->update($optionValue);
    }

    public function createOptionProduct(OptionProduct & $optionProduct)
    {
        $this->throwValidationErrors($optionProduct);
        $this->optionRepository->create($optionProduct);
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
     * @param UuidInterface $optionValueId
     * @return OptionValue
     */
    public function getOptionValueById(UuidInterface $optionValueId)
    {
        return $this->optionRepository->getOptionValueById($optionValueId);
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
