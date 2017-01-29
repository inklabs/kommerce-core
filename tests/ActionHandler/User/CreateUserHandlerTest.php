<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\CreateUserCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateUserHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $userDTO = $this->getDTOBuilderFactory()
            ->getUserDTOBuilder($this->dummyData->getUser())
            ->build();
        $command = new CreateUserCommand($userDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $user = $this->getRepositoryFactory()->getUserRepository()->findOneById(
            $command->getUserId()
        );
        $this->assertSame($userDTO->email, $user->getEmail());
    }
}
