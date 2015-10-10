<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreateTagHandlerTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $command = new CreateTagCommand($tag);

        $this->dispatch($command);

        $this->assertNotNull($command->getReturnId());
    }
}
