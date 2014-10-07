<?php
namespace inklabs\kommerce\Entity\Shipping;

use inklabs\kommerce\Entity;

class FedexRate extends Rate
{
	use Entity\Accessors;

	public $delivery_ts;
	public $transit_time;
}
