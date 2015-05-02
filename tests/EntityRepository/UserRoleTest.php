<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class UserRoleTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:UserRole',
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var UserRoleInterface */
    protected $userRoleRepository;

    public function setUp()
    {
        $this->userRoleRepository = $this->getUserRoleRepository();
    }

    public function setupUserWithRole()
    {
        $userRole = $this->getDummyUserRole();

        $user = $this->getDummyUser();
        $user->addRole($userRole);

        $this->entityManager->persist($userRole);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupUserWithRole();

        $this->setCountLogger();

        $userRole = $this->userRoleRepository->find(1);

        $this->assertTrue($userRole instanceof Entity\UserRole);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
