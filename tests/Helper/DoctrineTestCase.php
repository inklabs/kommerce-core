<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Service\Kommerce;
use Doctrine as Doctrine;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    /* @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /* @var Kommerce */
    protected $kommerce;

    /* @var CountSQLLogger */
    protected $countSQLLogger;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->getConnection();
        $this->setupTestSchema();
    }

    public function setEchoLogger()
    {
        $this->kommerce->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function setCountLogger()
    {
        $this->countSQLLogger = new CountSQLLogger;
        $this->kommerce->setSqlLogger($this->countSQLLogger);
    }

    private function getConnection()
    {
        $this->kommerce = new Kommerce(new Doctrine\Common\Cache\ArrayCache());
        $this->kommerce->addSqliteFunctions();
        $this->kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);

        $this->entityManager = $this->kommerce->getEntityManager();
    }

    private function setupTestSchema()
    {
        $this->entityManager->clear();

        $tool = new Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();
        // $tool->dropSchema($classes);
        $tool->createSchema($classes);
    }
}
