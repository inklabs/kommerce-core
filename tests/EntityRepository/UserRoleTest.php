<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class UserRoleTest extends Helper\DoctrineTestCase
{
    /**
     * @return UserRole
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:UserRole');
    }

    public function setUp()
    {
        $userRole = new Entity\UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account. Access to everything');

        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setUsername('johndoe');
        $user->setPassword('xxx');
        $user->addRole($userRole);

        $this->entityManager->persist($userRole);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\UserRole $userRole */
        $userRole = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $userRole->getId());
    }
}
