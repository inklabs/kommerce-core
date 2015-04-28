<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemOptionValueInterface
{
    /**
     * @param int $id
     * @return Entity\OrderItemOptionValue
     */
    public function find($id);
}
