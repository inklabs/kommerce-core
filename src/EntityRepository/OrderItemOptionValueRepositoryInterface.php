<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemOptionValue;

interface OrderItemOptionValueRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $id
     * @return OrderItemOptionValue
     */
    public function find($id);
}
