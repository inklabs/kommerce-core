<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
use inklabs\kommerce\EntityDTO\CashPaymentDTO;

/**
 * @method CashPaymentDTO build()
 */
class CashPaymentDTOBuilder extends AbstractPaymentDTOBuilder
{
    protected function getPaymentDTO()
    {
        return new CashPaymentDTO;
    }
}
