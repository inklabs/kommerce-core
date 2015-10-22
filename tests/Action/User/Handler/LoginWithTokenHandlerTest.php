<?php
namespace inklabs\kommerce\Action\User\Handler;

use DateTime;
use inklabs\kommerce\Action\User\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Response\LoginWithTokenResponse;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Service\UserService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserLoginRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserTokenRepository;

class LoginWithTokenHandlerTest extends DoctrineTestCase
{
    /** @var FakeUserRepository */
    protected $fakeUserRepository;

    /** @var FakeUserTokenRepository */
    protected $fakeUserTokenRepository;

    /** @var UserService */
    protected $userService;

    /** @var LoginWithTokenRequest */
    protected $request;

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

        $this->request = new LoginWithTokenRequest(
            'test1@example.com',
            'xxxx',
            '8.8.8.8'
        );
    }

    public function testExecute()
    {
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();
        $userToken->setExpires(new DateTime('+1 hour'));
        $user->addToken($userToken);
        $this->fakeUserRepository->create($user);
        $this->fakeUserTokenRepository->create($userToken);

        $getUserHandler = new LoginWithTokenHandler($this->userService);
        $response = new LoginWithTokenResponse;
        $getUserHandler->handle($this->request, $response);

        $this->assertTrue($response->getUserDTO() instanceof UserDTO);
    }

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager([
            'kommerce:User',
            'kommerce:UserRole',
            'kommerce:UserToken',
            'kommerce:UserLogin',
        ]);
        $user = $this->dummyData->getUser();
        $userToken = $this->dummyData->getUserToken();
        $userToken->setExpires(new DateTime('+1 hour'));
        $user->addToken($userToken);

        $this->getRepositoryFactory()->getUserRepository()->create($user);

        $response = new LoginWithTokenResponse;
        $this->getQueryBus()->execute($this->request, $response);

        $this->assertTrue($response->getUserDTO() instanceof UserDTO);
    }
}
