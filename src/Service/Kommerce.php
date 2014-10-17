<?php
namespace inklabs\kommerce\Service;

use Doctrine\DBAL\Logging\SQLLogger;
use inklabs\kommerce\Pricing;

class Kommerce
{
    protected $entityManager;
    protected $entityManagerConfiguration;

    public function __construct()
    {
        $this->setupEntityManager();
    }

    public static function factory()
    {
        static $object = null;
        if ($object === null) {
            $object = new self();
        }
        return $object;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setSqlLogger(SQLLogger $sqlLogger)
    {
        $this->entityManagerConfiguration->setSQLLogger($sqlLogger);
    }

    public function setupEntityManager()
    {
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'birdiesperch',
        );
        $paths = array(VENPATH . 'inklabs/kommerce/src/Entity');
        $isDevMode = true;

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(VENPATH . '/inklabs/kommerce/src/Doctrine/Mapping');
        $config->setMetadataDriverImpl($xmlDriver);
        // $cacheDriver = self::getCacheDriver();
        // $config->setMetadataCacheImpl($cacheDriver);
        // $config->setQueryCacheImpl($cacheDriver);

        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }
}
