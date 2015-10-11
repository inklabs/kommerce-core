<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Service\TagService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

class GetTagHandlerTest extends DoctrineTestCase
{
    public function testExecute()
    {
//        $tagId = 1;
//        $getTagAction = new GetTagHandler(new TagService(new FakeTagRepository));
//        $tag = $getTagAction->handle(new GetTagCommand($tagId));
//        $this->assertTrue($tag instanceof Tag);
    }
}
