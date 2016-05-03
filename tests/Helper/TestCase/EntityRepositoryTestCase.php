<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use Doctrine;
use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\DoctrineHelper;
use inklabs\kommerce\tests\Helper\CountSQLLogger;

abstract class EntityRepositoryTestCase extends KommerceTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /** @var CountSQLLogger */
    protected $countSQLLogger;

    /** @var string[] */
    protected $metaDataClassNames;

    public function setUp()
    {
        if ($this->metaDataClassNames !== null) {
            $this->setupEntityManager();
        }

        parent::setUp();
    }

    protected function setupEntityManager($metaDataClassNames = null)
    {
        if ($metaDataClassNames !== null) {
            $this->metaDataClassNames = $metaDataClassNames;
        }

        $this->getConnection();
        $this->setupTestSchema();
    }

    private function getConnection()
    {
        $this->doctrineHelper = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
        $this->doctrineHelper->setup([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
        $this->doctrineHelper->addSqliteFunctions();

        $this->entityManager = $this->doctrineHelper->getEntityManager();
    }

    protected function getRepositoryFactory()
    {
        return new RepositoryFactory($this->entityManager);
    }

    private function setupTestSchema()
    {
        if ($this->metaDataClassNames === null) {
            $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();
        } else {
            $classes = [];
            foreach ($this->metaDataClassNames as $className) {
                $classes[] = $this->entityManager->getMetaDataFactory()->getMetadataFor($className);
            }
        }

        $tool = new Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $tool->createSchema($classes);
    }

    public function setEchoLogger()
    {
        $this->doctrineHelper->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function setCountLogger($enableDisplay = false)
    {
        $this->countSQLLogger = new CountSQLLogger($enableDisplay);
        $this->doctrineHelper->setSqlLogger($this->countSQLLogger);
    }

    public function getTotalQueries()
    {
        return $this->countSQLLogger->getTotalQueries();
    }

    protected function beginTransaction()
    {
        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function rollback()
    {
        $this->entityManager->getConnection()->rollback();
    }

    protected function persistEntityAndFlushClear(EntityInterface $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
