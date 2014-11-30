<?php
namespace inklabs\kommerce\Entity\OrderStatus;

use inklabs\kommerce\Entity as Entity;

class Canceled implements Status
{
    public function getCode()
    {
        return Entity\Order::STATUS_CANCELED;
    }
}
