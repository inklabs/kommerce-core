<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . '/../vendor/autoload.php';

// replace with mechanism to retrieve EntityManager in your app

$config = new \Doctrine\ORM\Configuration();
$config->setAutoGenerateProxyClasses(true);
$config->setProxyDir(\sys_get_temp_dir());
$config->setProxyNamespace('inklabs\kommerce');
$config->setMetadataDriverImpl(new \Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/../src/Doctrine/Mapping'));
$config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());

$params = array(
    'driver' => 'pdo_sqlite',
    'memory' => true,
);

$entityManager = \Doctrine\ORM\EntityManager::create($params, $config);

return ConsoleRunner::createHelperSet($entityManager);
