<?php
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use inklabs\kommerce\ActionHandler\Migrate\MigrateToUUIDHandler;
use Symfony\Component\Console\Helper\HelperSet;

/** @var HelperSet $helperSet */
$helperSet = require_once __DIR__ . '/config/cli-config.php';

/** @var EntityManagerHelper $entityManagerHelper */
$entityManagerHelper = $helperSet->get('em');
$entityManager = $entityManagerHelper->getEntityManager();

$handler = new MigrateToUUIDHandler($entityManager);
$handler->handle();

// TODO: Remove after uuid_migration
