<?php
namespace inklabs\kommerce\tests\Helper\Service;

use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use Mockery;

class MockService
{
    /** @var DummyData */
    protected $dummyData;

    public function __construct(DummyData $dummyData)
    {
        $this->dummyData = $dummyData;
    }

    /**
     * @param string $className
     * @return Mockery\Mock
     */
    protected function getMockeryMock($className)
    {
        return Mockery::mock($className);
    }

    /**
     * @return TagServiceInterface | Mockery\Mock
     */
    public function getTagServiceMock()
    {
        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('findOneById')
            ->andReturn(
                $this->dummyData->getTag()
            );

        $tagService->shouldReceive('getAllTags')
            ->andReturn([
                $this->dummyData->getTag()
            ]);

        return $tagService;
    }

    /**
     * @return UserServiceInterface | Mockery\Mock
     */
    public function getUserServiceMock()
    {
        $userService = $this->getMockeryMock(UserServiceInterface::class);
        $userService->shouldReceive('loginWithToken')
            ->andReturn(
                $this->dummyData->getUser()
            );

        return $userService;
    }
}
