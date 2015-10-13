<?php
namespace inklabs\kommerce\Lib\Command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command);
}
