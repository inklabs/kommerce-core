<?php
namespace inklabs\kommerce\tests\Helper\Service;

use inklabs\kommerce\Service\TagServiceInterface;
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
     * @param string $className
     * @return Mockery\Mock
     */
    protected function getMockeryMock($className)
    {
        return Mockery::mock($className);
    }
}
