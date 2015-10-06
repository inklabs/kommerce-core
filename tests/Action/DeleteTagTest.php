<?php
namespace inklabs\kommerce\Action;

use inklabs\kommerce\Action\Tag\DeleteTag;
use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

class DeleteTagTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $action = new DeleteTag(new FakeTagRepository);
        $action->execute(new DeleteTagCommand(1));
    }
}
