<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Service\TagService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

class GetTagTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $tagId = 1;
        $action = new GetTag(new TagService(new FakeTagRepository));
        $tag = $action->execute(new GetTagCommand($tagId));
        $this->assertTrue($tag instanceof Tag);
    }
}
