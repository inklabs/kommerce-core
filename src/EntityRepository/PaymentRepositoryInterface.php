<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\Entity\CreditPayment;

/**
 * @method AbstractPayment | CheckPayment | CheckPayment | CreditPayment findOneById($id)
 */
interface PaymentRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return AbstractPayment[] | CheckPayment[] | CheckPayment[] | CreditPayment[]
     */
    public function findAll();
}
