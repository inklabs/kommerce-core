<?php
namespace inklabs\kommerce\Service;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    protected $entityManager;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->getConnection();
    }

    public function getConnection()
    {
        $kommerce = new Kommerce;
        $kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);

        $this->entityManager = $kommerce->getEntityManager();
    }
}
