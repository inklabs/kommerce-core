<?php
namespace inklabs\kommerce\Service;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    protected $entityManager;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->getConnection();
        $this->setupTestSchema();
    }

    private function getConnection()
    {
        $kommerce = new Kommerce;
        $kommerce->addSqliteFunctions();
        $kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);

        $this->entityManager = $kommerce->getEntityManager();
    }

    private function setupTestSchema()
    {
        $this->entityManager->clear();

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();

        $tool->dropSchema($classes);
        $tool->createSchema($classes);
    }
}
