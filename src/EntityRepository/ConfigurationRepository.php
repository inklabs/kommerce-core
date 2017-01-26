<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Configuration;

class ConfigurationRepository extends AbstractRepository implements ConfigurationRepositoryInterface
{
    /**
     * @param string $key
     * @return Configuration
     */
    public function findOneByKey($key)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['key' => $key])
        );
    }

    /**
     * @param string[] $keys
     * @return Configuration[]
     */
    public function findByKeys(array $keys)
    {
        return $this->getQueryBuilder()
            ->select('Configuration')
            ->from(Configuration::class, 'Configuration')
            ->where('Configuration.key IN (:keys)')
            ->setParameter('keys', $keys)
            ->orderBy('Configuration.key')
            ->getQuery()
            ->getResult();
    }
}
