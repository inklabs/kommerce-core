<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method TextOption findOneById(UuidInterface $id)
 */
interface TextOptionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface[] $optionIds
     * @param Pagination $pagination
     * @return TextOption[]
     */
    public function getAllTextOptionsByIds(array $optionIds, Pagination & $pagination = null);
}
