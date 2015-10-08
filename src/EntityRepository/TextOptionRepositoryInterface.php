<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;

/**
 * @package TextOption find($id)
 */
interface TextOptionRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int[] $optionIds
     * @param Pagination $pagination
     * @return TextOption[]
     */
    public function getAllTextOptionsByIds($optionIds, Pagination & $pagination = null);
}
