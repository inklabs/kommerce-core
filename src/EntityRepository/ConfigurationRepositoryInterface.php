<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Configuration;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Configuration findOneById(UuidInterface $id)
 */
interface ConfigurationRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $key
     * @return Configuration
     */
    public function findOneByKey($key);

    /**
     * @param string[] $keys
     * @return Configuration[]
     */
    public function findByKeys(array $keys);
}
