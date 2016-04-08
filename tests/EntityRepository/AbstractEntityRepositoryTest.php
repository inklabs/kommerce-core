<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class AbstractEntityRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        User::class,
    ];

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = $this->getRepositoryFactory()->getUserRepository();
    }

    public function testGetQueryBuilder()
    {
        $queryBuilder = $this->userRepository->getQueryBuilder();
        $this->assertTrue($queryBuilder instanceof QueryBuilder);
    }
}
