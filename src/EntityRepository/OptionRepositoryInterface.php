<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Option findOneById(UuidInterface $id)
 */
interface OptionRepositoryInterface extends RepositoryInterface
{
    public function getOptionProductById(UuidInterface $optionProductId): OptionProduct;

    /**
     * @param UuidInterface[] $optionIds
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptions(?string $queryString, Pagination & $pagination = null);
}
