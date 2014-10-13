<?php
namespace inklabs\kommerce\Entity\Shipping;

use inklabs\kommerce\Entity;

class Rate
{
    use Entity\Accessors;

    public $code;
    public $name;
    public $cost;
}
