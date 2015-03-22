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

        $userRole = $this->getRepository()
            ->find(1);

        $this->assertTrue($userRole instanceof Entity\UserRole);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
