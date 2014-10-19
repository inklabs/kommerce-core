<?php
namespace inklabs\kommerce\Service;

use Doctrine\DBAL\Logging\SQLLogger;

class Kommerce
{
    protected $entityManager;
    protected $entityManagerConfiguration;

    public function __construct()
    {
        $this->setupConfig();
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

    public function addSqliteFunctions()
    {
        $this->config->addCustomNumericFunction('RAND', 'inklabs\kommerce\Doctrine\Functions\Sqlite\Rand');
    }

    public function addMysqlFunctions()
    {
        $this->config->addCustomNumericFunction('RAND', 'inklabs\kommerce\Doctrine\Functions\Mysql\Rand');
    }

    public function setupConfig()
    {
        $paths = array(__DIR__ . '/../Entity');
        $isDevMode = true;

        $this->config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/../Doctrine/Mapping');
        $this->config->setMetadataDriverImpl($xmlDriver);
        // $cacheDriver = self::getCacheDriver();
        // $this->config->setMetadataCacheImpl($cacheDriver);
        // $this->config->setQueryCacheImpl($cacheDriver);
    }

    public function setup(array $dbParams)
    {
        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $this->config);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }
}
