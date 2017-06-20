<?php
namespace inklabs\kommerce\Lib;

use Doctrine;
use inklabs\kommerce\Doctrine\Extensions\TablePrefix;
use inklabs\kommerce\Doctrine\Extensions\UuidBinaryType;
use inklabs\kommerce\Doctrine\Functions as DoctrineFunctions;

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
        $this->config->addEntityNamespace('Entity', 'inklabs\kommerce\Entity');

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

    public function clearCache(): void
    {
        $this->cacheDriver->deleteAll();
    }

    public function getCacheDriver(): Doctrine\Common\Cache\CacheProvider
    {
        return $this->cacheDriver;
    }

    public function getEntityManager(): Doctrine\ORM\EntityManager
    {
        return $this->entityManager;
    }

    public function setSqlLogger(Doctrine\DBAL\Logging\SQLLogger $sqlLogger): void
    {
        $this->entityManagerConfiguration->setSQLLogger($sqlLogger);
    }

    public function setup(array $dbParams): void
    {
        $this->entityManager = Doctrine\ORM\EntityManager::create($dbParams, $this->config, $this->eventManager);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();

        $this->addUuidType();
        $this->addMysqlFunctions();
    }

    public function addMysqlFunctions(): void
    {
        $this->config->addCustomNumericFunction('RAND', DoctrineFunctions\Mysql\Rand::class);
        $this->config->addCustomNumericFunction('DISTANCE', DoctrineFunctions\Mysql\Distance::class);
    }

    public function addSqliteFunctions(): void
    {
        $pdo = $this->entityManager->getConnection()->getWrappedConnection();
        $pdo->sqliteCreateFunction('acos', 'acos');
        $pdo->sqliteCreateFunction('cos', 'cos');
        $pdo->sqliteCreateFunction('sin', 'sin');
        $pdo->sqliteCreateFunction('radians', 'deg2rad');
        $pdo->sqliteCreateFunction('rand', function ($seed = null) {
            if (isset($seed)) {
                mt_srand($seed);
            }

            return mt_rand() / mt_getrandmax();
        });
    }

    private function addUuidType(): void
    {
        $this->setupUuidType();
        $platform = $this->entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('uuid_binary', 'binary');
    }

    private function setupUuidType(): void
    {
        static $isAdded = false;
        if (! $isAdded) {
            Doctrine\DBAL\Types\Type::addType('uuid_binary', UuidBinaryType::class);
            $isAdded = true;
        }
    }
}
