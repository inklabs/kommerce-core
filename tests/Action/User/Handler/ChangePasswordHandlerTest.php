<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Event\PasswordChangedEvent;
use inklabs\kommerce\Service\UserService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserTokenRepository;

class ChangePasswordHandlerTest extends DoctrineTestCase
{
    /** @var FakeUserRepository */
    protected $fakeUserRepository;

    /** @var FakeUserTokenRepository */
    protected $fakeUserTokenRepository;

    /** @var UserService */
    protected $userService;

    /** @var ChangePasswordCommand */
    protected $command;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    public function setUp()
    {
        parent::setUp();

        $this->fakeUserRepository = new FakeUserRepository;
        $this->fakeUserTokenRepository = new FakeUserTokenRepository;
        $this->fakeEventDispatcher = new FakeEventDispatcher;

        $this->userService = new UserService(
            $this->fakeUserRepository,
            new FakeUserLoginRepository,
            $this->fakeUserTokenRepository,
            $this->fakeEventDispatcher
        );

        $this->command = new ChangePasswordCommand(
            1,
            'newPassword123'
        );
    }

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $this->fakeUserRepository->create($user);

        $handler = new ChangePasswordHandler($this->userService);
        $handler->handle($this->command);

        $user = $this->fakeUserRepository->findOneById(1);
        $this->assertTrue($user->verifyPassword('newPassword123'));

        /** @var PasswordChangedEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(PasswordChangedEvent::class)[0];
        $this->assertTrue($event instanceof PasswordChangedEvent);
        $this->assertSame(1, $event->getUserId());
        $this->assertSame('test1@example.com', $event->getEmail());
        $this->assertSame('John Doe', $event->getFullName());
    }

    public function testHandleThroughCommandBus()
    {
        $this->setupEntityManager([
            'kommerce:User',
            'kommerce:UserRole',
            'kommerce:UserToken',
        ]);
        $user = $this->dummyData->getUser();
        $this->getRepositoryFactory()->getUserRepository()->create($user);

        $this->getCommandBus()->execute($this->command);

        $user = $this->getRepositoryFactory()->getUserRepository()->findOneById(1);
        $this->assertTrue($user->verifyPassword('newPassword123'));
    }
}
