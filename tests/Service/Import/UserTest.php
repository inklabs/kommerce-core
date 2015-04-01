<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class UserTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\User */
    protected $mockUserRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var User */
    protected $userService;

    public function setUp()
    {
        $this->mockUserRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\User');

        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->mockUserRepository);

        $this->userService = new User($this->mockEntityManager);
    }

    public function testImport()
    {
        $this->mockEntityManager
            ->shouldReceive('persist')
            ->times(3)
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->once()
            ->andReturnUndefined();

        $iterator = new Lib\CSVIterator(__DIR__ . '/UserTest.csv');
        $importedCount = $this->userService->import($iterator);

        $this->assertSame(3, $importedCount);
    }
}
