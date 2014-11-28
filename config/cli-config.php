<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use inklabs\kommerce\Service\Kommerce;

require_once __DIR__ . '/../vendor/autoload.php';

$kommerce = new Kommerce(new Doctrine\Common\Cache\ArrayCache());
$kommerce->setup([
    'driver' => 'pdo_mysql',
    'dbname' => 'test',
    'user' => 'root',
    'password' => 'rooty',
    'host' => '127.0.0.1',
    'port' => '4409',
]);

$entityManager = $kommerce->getEntityManager();
return ConsoleRunner::createHelperSet($entityManager);
