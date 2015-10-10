<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class EditTagHandlerTest extends DoctrineTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $updated = $tag->getUpdated();
        $tag->setName('New Name');

        $this->dispatch(new EditTagCommand($tag));

        $this->assertNotSame($updated, $tag->getUpdated());
    }
}
