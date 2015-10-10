<?php
namespace inklabs\kommerce\tests\Action\Fake;

class FakeUpdateHandler
{
    public function handle(FakeUpdateCommand $command)
    {
        $command->getName();
        $command->getEmail();
        $command->setReturnId(1);
    }
}
