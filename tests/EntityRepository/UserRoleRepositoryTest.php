<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\tests\Helper;

class UserRoleRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        UserRole::class,
        User::class,
        Cart::class,
    ];

    /** @var UserRoleRepositoryInterface */
    protected $userRoleRepository;

    public function setUp()
    {
        parent::setUp();
        $this->userRoleRepository = $this->getRepositoryFactory()->getUserRoleRepository();
    }

    public function setupUserWithRole()
    {
        $userRole = $this->dummyData->getUserRole();

        $user = $this->dummyData->getUser();
        $user->addUserRole($userRole);

        $this->entityManager->persist($userRole);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $userRole = $this->dummyData->getUserRole();

        $this->userRoleRepository->create($userRole);
        $this->assertSame(1, $userRole->getId());

        $userRole->setName('New Name');
        $this->assertSame(null, $userRole->getUpdated());

        $this->userRoleRepository->update($userRole);
        $this->assertTrue($userRole->getUpdated() instanceof DateTime);

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
