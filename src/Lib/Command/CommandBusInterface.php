<?php
namespace inklabs\kommerce\Lib\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command);
}
