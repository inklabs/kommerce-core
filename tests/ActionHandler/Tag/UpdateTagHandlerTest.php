<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);

        $tagDTO = $this->getDTOBuilderFactory()
            ->getTagDTOBuilder($tag)
            ->build();

        $name = 'changed name';
        $tagDTO->name = $name;

        $command = new UpdateTagCommand($tagDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
        $this->assertSame($name, $tag->getName());
    }
}
