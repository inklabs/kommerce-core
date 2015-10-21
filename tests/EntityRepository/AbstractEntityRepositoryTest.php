<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder as KommerceQueryBuilder;
use inklabs\kommerce\tests\Helper;

class AbstractEntityRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
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
        $this->assertTrue($queryBuilder instanceof KommerceQueryBuilder);
    }
}
