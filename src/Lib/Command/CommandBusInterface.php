<?php
namespace inklabs\kommerce\Lib\Command;

interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command);
}
