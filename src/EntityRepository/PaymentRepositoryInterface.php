<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method AbstractPayment | CheckPayment | CheckPayment | CreditPayment findOneById(UuidInterface $id)
 */
interface PaymentRepositoryInterface extends RepositoryInterface
{
    /**
     * @return AbstractPayment[] | CheckPayment[] | CheckPayment[] | CreditPayment[]
     */
    public function findAll();
}
