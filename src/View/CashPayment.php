<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CashPayment extends AbstractPayment
{
    public function __construct(Entity\CashPayment $cash)
    {
        parent::__construct($cash);

        return $this;
    }
}
