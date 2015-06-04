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
        $this->userRoleRepository = $this->repository()->getUserRole();
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

    public function testCRUD()
    {
        $userRole = $this->getDummyUserRole();

        $this->userRoleRepository->create($userRole);
        $this->assertSame(1, $userRole->getId());

        $userRole->setName('New Name');
        $this->assertSame(null, $userRole->getUpdated());

        $this->userRoleRepository->save($userRole);
        $this->assertTrue($userRole->getUpdated() instanceof \DateTime);

        $this->userRoleRepository->remove($userRole);
        $this->assertSame(null, $userRole->getId());
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
