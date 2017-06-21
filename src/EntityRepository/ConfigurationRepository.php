<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Configuration;

class ConfigurationRepository extends AbstractRepository implements ConfigurationRepositoryInterface
{
    public function findOneByKey(string $key): Configuration
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
