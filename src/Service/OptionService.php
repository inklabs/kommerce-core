<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;
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

    public function update(Option & $option)
    {
        $this->optionRepository->update($option);
    }

    public function updateOptionValue(OptionValue & $optionValue)
    {
        $this->optionRepository->update($optionValue);
    }

    public function updateOptionProduct(OptionProduct & $optionProduct)
    {
        $this->optionRepository->update($optionProduct);
    }

    public function updateTextOption(TextOption & $textOption)
    {
        $this->optionRepository->update($textOption);
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
     * @param UuidInterface $optionProductId
     * @return OptionProduct
     */
    public function getOptionProductById(UuidInterface $optionProductId)
    {
        return $this->optionRepository->getOptionProductById($optionProductId);
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
