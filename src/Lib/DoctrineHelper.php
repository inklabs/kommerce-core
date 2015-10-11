<?php
namespace inklabs\kommerce\Lib;

use Doctrine;
use inklabs\kommerce\Doctrine\Extensions\TablePrefix;
use \inklabs\kommerce\Doctrine\Functions as DoctrineFunctions;

class DoctrineHelper
{
    protected $tablePrefix = 'zk_';
    protected $eventManager;

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Doctrine\DBAL\Configuration */
    protected $entityManagerConfiguration;

    /** @var Doctrine\Common\Cache\CacheProvider */
    protected $cacheDriver;

    /** @var Doctrine\DBAL\Configuration */
    protected $config;

    public function __construct(Doctrine\Common\Cache\CacheProvider $cacheDriver = null)
    {
        $paths = [__DIR__ . '/../Entity'];
        $isDevMode = true;

        $this->config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new Doctrine\ORM\Mapping\Driver\XmlDriver(realpath(__DIR__ . '/../Doctrine/Mapping'));
        $this->config->setMetadataDriverImpl($xmlDriver);
        $this->config->addEntityNamespace('kommerce', 'inklabs\kommerce\Entity');

        if ($cacheDriver !== null) {
            $this->cacheDriver = $cacheDriver;
            $this->config->setMetadataCacheImpl($this->cacheDriver);
            $this->config->setQueryCacheImpl($this->cacheDriver);
            $this->config->setResultCacheImpl($this->cacheDriver);
        }

        $tablePrefix = new TablePrefix($this->tablePrefix);
        $this->eventManager = new Doctrine\Common\EventManager;
        $this->eventManager->addEventListener(Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
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

    public function setSqlLogger(Doctrine\DBAL\Logging\SQLLogger $sqlLogger)
    {
        $this->entityManagerConfiguration->setSQLLogger($sqlLogger);
    }

    public function addSqliteFunctions()
    {
        $this->config->addCustomNumericFunction('RAND', DoctrineFunctions\Sqlite\Rand::class);
        $this->config->addCustomNumericFunction('DISTANCE', DoctrineFunctions\Sqlite\Distance::class);
    }

    public function addMysqlFunctions()
    {
        $this->config->addCustomNumericFunction('RAND', DoctrineFunctions\Mysql\Rand::class);
        $this->config->addCustomNumericFunction('DISTANCE', DoctrineFunctions\Mysql\Distance::class);
    }

    public function setup(array $dbParams)
    {
        $this->entityManager = Doctrine\ORM\EntityManager::create($dbParams, $this->config, $this->eventManager);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }
}
