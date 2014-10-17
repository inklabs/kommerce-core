<?php
namespace inklabs\kommerce\Service;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    protected $entityManager;
    protected $entityManagerConfiguration;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->getConnection();
    }

    public function getConnection()
    {
        $dbParams = [
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ];

        $paths = array(__DIR__ . '/../Entity');
        $isDevMode = true;

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/../Doctrine/Mapping');
        $config->setMetadataDriverImpl($xmlDriver);

        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();
    }
}
