<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\tests\Helper;

class UserRoleRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:UserRole',
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var UserRoleRepositoryInterface */
    protected $userRoleRepository;

    public function setUp()
    {
        $this->userRoleRepository = $this->getRepositoryFactory()->getUserRoleRepository();
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

        $this->userRoleRepository->update($userRole);
        $this->assertTrue($userRole->getUpdated() instanceof \DateTime);

        $this->userRoleRepository->delete($userRole);
        $this->assertSame(null, $userRole->getId());
    }

    public function testFind()
    {
        $this->setupUserWithRole();

        $this->setCountLogger();

        $userRole = $this->userRoleRepository->findOneById(1);

        $this->assertTrue($userRole instanceof UserRole);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
