<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\OptionValue;
use Ramsey\Uuid\UuidInterface;

/**
 * @method OptionValue findOneById(UuidInterface $id)
 */
interface OptionValueRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface[] $optionValueIds
     * @param Pagination $pagination
     * @return OptionValue[]
     */
    public function getAllOptionValuesByIds(array $optionValueIds, Pagination & $pagination = null);
}
