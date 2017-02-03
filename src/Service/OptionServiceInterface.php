<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface OptionServiceInterface
{
    public function update(Option & $option);
    public function updateOptionValue(OptionValue & $optionValue);
    public function updateOptionProduct(OptionProduct & $optionProduct);
    public function updateTextOption(TextOption & $textOption);

    /**
     * @param UuidInterface $id
     * @return Option
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptions($queryString = null, Pagination &$pagination = null);

    /**
     * @param UuidInterface $optionValueId
     * @return OptionValue
     */
    public function getOptionValueById(UuidInterface $optionValueId);

    /**
     * @param UuidInterface $optionProductId
     * @return OptionProduct
     */
    public function getOptionProductById(UuidInterface $optionProductId);
}
