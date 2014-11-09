<?php
namespace inklabs\kommerce\Service;

use Doctrine\DBAL\Logging\SQLLogger;

class Kommerce
{
    protected $entityManager;
    protected $entityManagerConfiguration;
    protected $sessionManager;
    protected $pricing;
    protected $cacheDriver;
    protected $config;

    public function __construct(\Doctrine\Common\Cache\CacheProvider $cacheDriver = null)
    {
        $paths = array(__DIR__ . '/../Entity');
        $isDevMode = true;

        $this->config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(realpath(__DIR__ . '/../Doctrine/Mapping'));
        $this->config->setMetadataDriverImpl($xmlDriver);

        if ($cacheDriver !== null) {
            $this->cacheDriver = $cacheDriver;
            $this->config->setMetadataCacheImpl($this->cacheDriver);
            $this->config->setQueryCacheImpl($this->cacheDriver);
            $this->config->setResultCacheImpl($this->cacheDriver);
        }
    }

    public function service($serviceClassName)
    {
        $serviceClassName = 'inklabs\kommerce\Service\\' . $serviceClassName;
        $serviceClass = new $serviceClassName($this->entityManager);
        return $serviceClass;
    }

    public function pricingService($serviceClassName)
    {
        $serviceClassName = 'inklabs\kommerce\Service\\' . $serviceClassName;
        $serviceClass = new $serviceClassName($this->entityManager, $this->pricing);
        return $serviceClass;
    }

    public function pricingSessionService($serviceClassName)
    {
        $serviceClassName = 'inklabs\kommerce\Service\\' . $serviceClassName;
        $serviceClass = new $serviceClassName($this->entityManager, $this->pricing, $this->sessionManager);
        return $serviceClass;
    }

    public function clearCache()
    {
        $this->cacheDriver->deleteAll();
    }

    public function getCacheDriver()
    {
        return $this->cacheDriver;
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

    public function setup(array $dbParams)
    {
        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $this->config);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }

    public function setSessionManager($sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function setupPricingWithCatalogPromotions()
    {
        $this->pricing = new Pricing;
        $this->pricing->loadCatalogPromotions($this->entityManager);
    }
}
