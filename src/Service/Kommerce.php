<?php
namespace inklabs\kommerce\Service;

use Doctrine\DBAL\Logging\SQLLogger;

class Kommerce
{
    protected $entityManager;
    protected $entityManagerConfiguration;

    public function __construct(array $dbParams)
    {
        $this->setup($dbParams);
    }

    public function service($serviceClassName)
    {
        $serviceClassName = 'inklabs\kommerce\Service\\' . $serviceClassName;
        return new $serviceClassName($this->entityManager);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setSqlLogger(SQLLogger $sqlLogger)
    {
        $this->entityManagerConfiguration->setSQLLogger($sqlLogger);
    }

    public function setup(array $dbParams)
    {
        $paths = array(__DIR__ . '/../Entity');
        $isDevMode = true;

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/../Doctrine/Mapping');
        $config->setMetadataDriverImpl($xmlDriver);
        // $cacheDriver = self::getCacheDriver();
        // $config->setMetadataCacheImpl($cacheDriver);
        // $config->setQueryCacheImpl($cacheDriver);

        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }
}
