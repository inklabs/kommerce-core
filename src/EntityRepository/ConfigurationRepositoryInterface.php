<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Configuration findOneById(UuidInterface $id)
 */
interface ConfigurationRepositoryInterface extends RepositoryInterface
{
    public function findOneByKey(string $key): Configuration;

    /**
     * @param string[] $keys
     * @return Configuration[]
     */
    public function findByKeys(array $keys);
}
