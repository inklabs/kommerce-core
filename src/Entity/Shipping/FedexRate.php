<?php
namespace inklabs\kommerce\Entity\Shipping;

use inklabs\kommerce\Entity;

class Shipping\FedexRate extends Shipping\Rate
{
	use Accessors;

	public $delivery_ts;
	public $transit_time;
}
