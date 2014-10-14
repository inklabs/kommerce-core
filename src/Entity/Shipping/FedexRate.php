<?php
namespace inklabs\kommerce\Entity\Shipping;

use inklabs\kommerce\Entity;

class FedexRate extends Rate
{
    public $delivery_ts;
    public $transit_time;
}
