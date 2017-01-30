<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteTagHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Tag::class,
        Product::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);
        $command = new DeleteTagCommand($tag->getId()->getHex());

        $this->dispatchCommand($command);

        $this->setExpectedException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getTagRepository()->findOneById(
            $tag->getId()
        );
    }
}
