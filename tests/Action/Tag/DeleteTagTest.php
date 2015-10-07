<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Service\TagService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

class DeleteTagTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $action = new DeleteTag(new TagService(new FakeTagRepository));
        $action->execute(new DeleteTagCommand(1));
    }
}
