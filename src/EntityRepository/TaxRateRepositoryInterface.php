<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method TaxRate findOneById(UuidInterface $id)
 */
interface TaxRateRepositoryInterface extends RepositoryInterface
{
    /**
     * @return TaxRate[]
     */
    public function findAll();

    public function findByZip5AndState(string $zip5 = null, string $state = null): ?TaxRate;
}
