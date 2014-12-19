<?php
namespace inklabs\kommerce\Entity\View\Payment;

use inklabs\kommerce\Entity as Entity;

class Cash extends Payment
{
    public function __construct(Entity\Payment\Cash $cash)
    {
        parent::__construct($cash);

        return $this;
    }
}
