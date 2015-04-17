<?php
namespace inklabs\kommerce\View\Payment;

use inklabs\kommerce\Entity;

class Cash extends Payment
{
    public function __construct(Entity\Payment\Cash $cash)
    {
        parent::__construct($cash);

        return $this;
    }
}
