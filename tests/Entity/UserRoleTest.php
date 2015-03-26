<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $userRole = new UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account with access to everything.');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($userRole));
        $this->assertSame('Administrator', $userRole->getName());
        $this->assertSame('Admin account with access to everything.', $userRole->getDescription());
        $this->assertTrue($userRole->getView() instanceof View\UserRole);
    }
}
