<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class UserRoleRepositoryTest extends EntityRepositoryTestCase
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

        return $userRole;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->userRoleRepository,
            $this->dummyData->getUserRole()
        );
    }

    public function testFind()
    {
        $originalUserRole = $this->setupUserWithRole();
        $this->setCountLogger();

        $userRole = $this->userRoleRepository->findOneById(
            $originalUserRole->getId()
        );

        $this->assertEqualEntities($originalUserRole, $userRole);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
