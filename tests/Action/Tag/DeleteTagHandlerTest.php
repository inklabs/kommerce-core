<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class DeleteTagHandlerTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $tagId = 1;
        $command = new DeleteTagCommand($tagId);

        $this->dispatch($command);
    }
}
