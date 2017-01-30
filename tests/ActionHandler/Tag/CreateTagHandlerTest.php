<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
    ];

    public function testHandle()
    {
        $tagDTO = $this->getDTOBuilderFactory()
            ->getTagDTOBuilder($this->dummyData->getTag())
            ->build();
        $command = new CreateTagCommand($tagDTO);

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $tag = $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $command->getTagId()
        );
        $this->assertSame($tagDTO->code, $tag->getCode());
        $this->assertSame($tagDTO->name, $tag->getName());
        $this->assertSame($tagDTO->description, $tag->getDescription());
    }
}
